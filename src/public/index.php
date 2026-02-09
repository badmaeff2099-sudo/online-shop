<?php



$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// регистрация
if($requestUri === '/registration') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getRegistrate();
    } elseif ($requestMethod === 'POST') {
        $user->registrate();
    } else {
        echo "$requestMethod для адреса $requestUri не поддерживается";
    }

}
// логин
elseif($requestUri === '/login') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getLogin();
    } elseif ($requestMethod === 'POST') {
        $user->login();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }
}

// выдача профиля
elseif ($requestUri === '/profile') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->profile();
    } elseif ($requestMethod === 'POST'){
        $user->getProfile();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }
}
// изменение профиля
elseif ($requestUri === '/profile-change') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getEditProfile();
    } elseif ($requestMethod === 'POST'){
        $user->editProfile();
    } else {
        echo "HTTP метод $requestMethod не работает";
    }
}
// добавление товара
elseif ($requestUri === '/add-product') {
    if ($requestMethod === 'GET') {
        require_once './addProduct/add_product_form.php';
          } elseif ($requestMethod === 'POST'){
            require_once './addProduct/handle_add_product.php';
    }
}

// каталог
elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog/catalog.php';
    }
}

else {
        http_response_code(404);
        require_once './404.php';
    }


#$statement = $pdo->query("SELECT * FROM users WHERE id = 2");

#$data = $statement->fetch();
#echo "<pre>";
#print_r($data);
#echo "<pre>";

//elseif ($requestUri === '/handle_login') {
//require_once './handle_login.php';
//} elseif ($requestUri === '/catalog') {
//require_once './catalog.php';
//}