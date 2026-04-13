<?php

use Controller\CartController;
use Controller\CatalogController;
use Controller\LogoutController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

require_once './../Core/Autoloader.php';

$path = dirname(__DIR__);
Core\Autoloader::register($path); // статический метод ,поэтому можно вызывать без объекта

$app = new Core\App();
$app->get('/registration', UserController::class, 'getRegistrate');
$app->post('/registration', UserController::class, 'registrate');

$app->get('/login',UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login');

$app->get('/profile', UserController::class, 'profile');
$app->post('/profile', UserController::class, 'getProfile');

$app->get('/profile-change', UserController::class, 'getEditProfile');
$app->post('/profile-change',UserController::class, 'editProfile');

$app->get('/add-product',ProductController::class, 'getProduct');
$app->post('/add-product', ProductController::class, 'addProduct');

$app->get('/catalog', CatalogController::class, 'getCatalog');

$app->get('/cart', CartController::class, 'getCart');

$app->post('/update-cart', ProductController::class, 'changeProduct');

$app->post('/delete-product', ProductController::class, 'deleteProduct');

$app->get('/logout',LogoutController::class, 'logout');

$app->get('/create-order', OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout');

$app->get('/user-orders', OrderController::class, 'getAllOrders');

$app->run();

