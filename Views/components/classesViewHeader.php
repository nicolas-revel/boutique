<?php

namespace app\views\components;

require'../vendor/autoload.php';

class viewHeader extends \app\controllers\Controllerheader
{
    /**
     * Méthode qui permet d'afficher les categories et ses sous-categories dans le dropdown (Header)
     */
    public function showNameCategorie()
    {

        $modelHeader = new \app\models\Modelheader();
        $table = $modelHeader->allCategory();
        $subCat = $this->allSubCategory();

        foreach ($table as $key => $value) {

            echo "<h3 id='titleDropdown'><a href='#'>".$value['category_name']."</a></h3>";

            foreach ($subCat as $keySub => $valueSub) {

                if($value['id_category'] === $valueSub['id_category']) {

                    echo "<a id='subCatText' href='#'>".$valueSub['subcategory_name']."</a>";
                }
            }

        }

    }

    public function showButtonConnectUser ()
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])){ ?>

            <li><a href="../Views/profil.php">MON COMPTE</a></li>
            <li><i class="fas fa-user"></i><?= $_SESSION['user']->getEmail(); ?></li>

        <?php
        } elseif(!isset($_SESSION['user']) && empty($_SESSION['user'])){ ?>
            <li><a href="../inscription.php">INSCRIPTION</a></li>
            <li><a href="../Views/connexion.php">CONNEXION</a></li>
        <?php
        }else { ?>
            <li><a href="../Views/admin.php">ADMIN</a></li>
        <?php
        }

    }


}
