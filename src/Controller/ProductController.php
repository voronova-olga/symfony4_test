<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\PriceCreateForm;
use App\Form\PriceEditForm;
use App\Service\LogPriceService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/product/list", name="product_list")
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();
        return $this->render('product/index_list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(PriceCreateForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $new = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $product = new Product();
            $product->setPrice($new['price']);
            $product->setName($new['name']);
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('product_list');
        }
        return $this->render('product/price_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/priceedit/{id}", name="product_price_edit")
     */
    public function priceeditAction($id, Request $request)
    {
        $id = intval($id);
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $form = $this->createForm(PriceEditForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $new = $form->getData();
            if($new['price']!=$product->getPrice()){
                $em = $this->getDoctrine()->getManager();
                $service = new LogPriceService();
                $service->logPrice($em, $product);
                $product->setPrice($new['price']);
                $em->persist($product);
                $em->flush();
            }else{
                //  Если пришедшие данные такие же как и те, что в базе данных, то ничего не делаем!
            }
            return $this->redirectToRoute('product_list');
        }
        $form->get('price')->setData($product->getPrice());
        return $this->render('product/price_edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}
