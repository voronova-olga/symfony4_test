<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogPriceRepository")
 */
class LogPrice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $datetime;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    private $oldprice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="id")
     * @ORM\JoinColumn(name="product_id", nullable=false)
     */
    private $product;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @return mixed
     */
    public function getOldprice()
    {
        return $this->oldprice;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    public function Create($product){
        $this->product = $product;
        $this->oldprice = $product->getPrice();
        $this->datetime = new \DateTime("now");
    }

}
