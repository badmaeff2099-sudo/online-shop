<?php

namespace Core;

use Controller\CartController;
use Controller\CatalogController;
use Controller\LogoutController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

class App
{

    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registrate'
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login'
            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'profile'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'getProfile'
            ],
        ],
        '/profile-change' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getEditProfile'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'editProfile'
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getProduct'
            ],
            'POST' => [
                'class' => ProductController::class,
                'method' => 'addProduct'
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class' => CatalogController::class,
                'method' => 'getCatalog'
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCart'
            ],
        ],
        '/update-cart' => [
            'POST' => [
                'class' => ProductController::class,
                'method' => 'changeProduct'
            ],
        ],
        '/delete-product' => [
            'POST' => [
                'class' => ProductController::class,
                'method' => 'deleteProduct'
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => LogoutController::class,
                'method' => 'logout'
            ],
        ],
        '/create-order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getCheckoutForm'
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'handleCheckout'
            ],
        ],
    ];


    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];


                $controller = new $class();
                $controller->$method();
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        }else{
            http_response_code(404);
            require_once '../Views/404.php';

        }
    }
}