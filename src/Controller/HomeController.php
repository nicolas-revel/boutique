<?php

namespace App\Controller;

use App\Model\ProductModel;

class HomeController extends AbstractController
{

    public function index()
    {
        $productModel = new ProductModel();

        $this->render('home/index', [
            'title' => 'Accueil',
        ]);
    }
}