<?php

namespace App\Service;

use App\Entity\LogPrice;

class LogPriceService
{
    public function logPrice($em, $product)
    {
        $log = new LogPrice;
        $log->Create($product);
        $em->persist($log);
        $em->flush();
        return true;
    }
}