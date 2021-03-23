<?php

namespace app\controllers;


class Controlleraccueil extends \app\models\Modelaccueil
{
    public function index (){
        Header('Location: ../boutique/views/accueil.php');
    }

    public function addCategory()
    {
        $directory = 'imagecategory';

        if (!empty($_POST['categoryName'])) {

            $category_name = htmlspecialchars(trim($_POST['categoryName']));

            if (isset($_FILES['fileimg']) and !empty($_FILES['fileimg']['name'])) {

                $uploadPictureCategory = $this->controlPicture($_FILES['fileimg'], $directory);
                $this->addCategoryBdd($category_name, $uploadPictureCategory);

            }
        }
    }

    public function getIdTerrarium (){

        $selectCategory = $this->allCategory();

        foreach($selectCategory as $k => $v){
            if($v['category_name'] == 'Terrariums'){
                $idCat = $v['id_category'];
                echo $idCat;
            }
        }

    }

    public function selectSubCategory()
    {
        $subCategory = $this->allSubCategory();

        foreach ($subCategory as $key => $value) {

            $tab[$value['id_subcategory']] = $value['subcategory_name'];
        }

        return $tab;
    }

    public function controlPicture($file, $directory)
    {
        $tailleMax = 250000;
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');

        if($file['size'] <= $tailleMax) {

            $extensionUpload = strtolower(substr(strrchr($file['name'], '.'), 1));

            if (in_array($extensionUpload, $extensionsValides)) {

                $nomImage = md5(uniqid()) . '.' . $extensionUpload;

                $chemin = "../images/$directory/$nomImage";

                move_uploaded_file($file['tmp_name'], $chemin);

                return $nomImage;
            }
        }
    }


    public function addProduct()
    {
        if (!empty($_POST['nameProduct']) && ($_POST['descriptionProduct']) && ($_POST['priceProduct']) && ($_POST['selectSubCat'])) {

            $name = htmlspecialchars(trim($_POST['nameProduct']));
            $description = htmlspecialchars(trim($_POST['descriptionProduct']));
            $price = htmlspecialchars(trim($_POST['priceProduct']));
            $id_subcategory = htmlspecialchars(trim($_POST['selectSubCat']));

            if (isset($_FILES['fileimg']) and !empty($_FILES['fileimg']['name'])) {

               $uploadPictureProduct = $this->controlPicture($_FILES['fileimg'], 'imageboutique');

               $this->addProductBdd($name, $description, $price, $id_subcategory, $uploadPictureProduct);
            }
        }
    }





}

