<?php

namespace app\controllers;

class Controlleraccueil extends \app\models\Modelaccueil
{
    public function addCategory()
    {
        if (!empty($_POST['categoryName'])) {

            $category_name = htmlspecialchars(trim($_POST['categoryName']));

            if (isset($_FILES['fileimg']) and !empty($_FILES['fileimg']['name'])) {

                define('TARGET', '../images/imagecategory/');    // Repertoire cible
                define('MAX_SIZE', 250000);    // Taille max en octets du fichier
                define('WIDTH_MAX', 1000);    // Largeur max de l'image en pixels
                define('HEIGHT_MAX', 1000);    // Hauteur max de l'image en pixels

                $tabExt = array('jpg', 'gif', 'png', 'jpeg', 'webp');    // Extensions autorisees

                // Recuperation de l'extension du fichier
                $extension = pathinfo($_FILES['fileimg']['name'], PATHINFO_EXTENSION);

                // On verifie l'extension du fichier
                if (in_array(strtolower($extension), $tabExt)) {

                    // On recupere les dimensions du fichier
                    $infosImg = getimagesize($_FILES['fileimg']['tmp_name']);

                    // On verifie le type de l'image
                    if ($infosImg[2] >= 1 && $infosImg[2] <= 14) {

                        // On verifie les dimensions et taille de l'image
                        if (($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fileimg']['tmp_name']) <= MAX_SIZE)) {

                            // Parcours du tableau d'erreurs
                            if (isset($_FILES['fileimg']['error']) && UPLOAD_ERR_OK === $_FILES['fileimg']['error']) {

                                // On renomme le fichier
                                $nomImage = md5(uniqid()) . '.' . $extension;

                                // Si c'est OK, on teste l'upload
                                if (move_uploaded_file($_FILES['fileimg']['tmp_name'], TARGET . $nomImage)) {

                                    $this->addCategoryBdd($category_name, $nomImage);

                                }

                            }
                        }
                    }
                }
            }
        }
    }



}

