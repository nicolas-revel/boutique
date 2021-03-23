<?php

try
{
    require_once "vendor/autoload.php";

    $control = new \app\controllers\Controlleraccueil();

    if (!empty($_GET['url']))
    {
        $action = $_GET['url'];

        if ($action == 'accueil')
        {
            $control->index();

        }
    }

    else
    {
        $control->index(); // Action par défaut;
    }
}

catch (Exception $e)
{
    die('Error: ' . $e);
}