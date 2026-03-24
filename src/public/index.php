<?php

use Controller\CartController;
use Controller\CatalogController;
use Controller\LogoutController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

$autoload = function (string $className){
    $path = "./../".str_replace('\\', '/', $className).".php";

    if(file_exists($path)) {
        require_once $path;
        return true; // дальше можно не использовать else т.к. return
    }
    return false;
};

spl_autoload_register($autoload);


$app = new Core\App();
$app->addRoute('/registration','GET', UserController::class, 'getRegistrate');
$app->addRoute('/registration','POST', UserController::class, 'registrate');

$app->addRoute('/login','GET', UserController::class, 'getLogin');
$app->addRoute('/login','POST', UserController::class, 'login');

$app->addRoute('/profile','GET', UserController::class, 'profile');
$app->addRoute('/profile','POST', UserController::class, 'getProfile');

$app->addRoute('/profile-change','GET', UserController::class, 'getEditProfile');
$app->addRoute('/profile-change','POST', UserController::class, 'editProfile');

$app->addRoute('/add-product','GET', ProductController::class, 'getProduct');
$app->addRoute('/add-product','POST', ProductController::class, 'addProduct');

$app->addRoute('/catalog','GET', CatalogController::class, 'getCatalog');

$app->addRoute('/cart','GET', CartController::class, 'getCart');

$app->addRoute('/update-cart','POST', ProductController::class, 'changeProduct');

$app->addRoute('/delete-product','POST', ProductController::class, 'deleteProduct');

$app->addRoute('/logout','POST', LogoutController::class, 'logout');

$app->addRoute('/create-order','GET', OrderController::class, 'getCheckoutForm');
$app->addRoute('/create-order','POST', OrderController::class, 'handleCheckout');

$app->addRoute('/user-orders','GET', OrderController::class, 'getAllOrders');

$app->run();

