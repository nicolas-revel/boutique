<?php

namespace App\Controller;

class AdminController extends AbstractController
{

    public function index($table = null, $action = null, $id = null)
    {
        $this->redirectToRoute('admin_table_list', [
            'table' => 'user',
            'action' => 'list',
            'id' => ''
        ]);
    }

}