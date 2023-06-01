<?php

namespace App\Controller;

use App\Model\UserModel;

class UserAdminController extends AdminController
{

    public function list()
    {
        $userModel = new UserModel();
    }

}