<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $params['title'] ?></title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="">Accueil</a></li>
            <li><a href="shop">Produits</a></li>
            <li><a href="authentification">S'authentifier</a></li>
        </ul>
    </nav>
</header>

<?= $content ?>


</body>
</html>

