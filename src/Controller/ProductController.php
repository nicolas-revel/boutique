<?php

namespace App\Controller;

class ProductController extends AbstractController
{
    public function show($id, $action)
    {
        $this->render('product/show', [
            'id' => $id,
            'action' => $action
        ]);
    }
}