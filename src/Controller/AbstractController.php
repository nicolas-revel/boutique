<?php

namespace App\Controller;

use App\Entity\User;
use App\Router\Router;
use App\Router\RouterException;

abstract class AbstractController
{

    public function __construct(
        private Router $router
    ) {
    }

    protected function render(string $view, array $params = []): void
    {
        extract($params);
        ob_start();
        define('ROOT', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
        require(ROOT . 'src/View/' . $view . '.php');
        $content = ob_get_clean();
        require(ROOT . 'src/View/layout.php');
    }

    protected function notFound()
    {
        header('HTTP/1.1 404 Not Found');
        $this->render('404');
    }

    protected function redirectToRoute(string $routeName, array $params = []): void
    {
        try {
            $path = $this->router->generate($routeName, $params);

            header('Location: ' . $_ENV['BASE_URI'] . $path);
        } catch (RouterException $e) {
            $this->notFound();
        }

        exit();
    }

    protected function getUser(): ?User
    {
        var_dump($_SESSION['user'] ?? null);
        return $_SESSION['user'] ?? null;
    }

}