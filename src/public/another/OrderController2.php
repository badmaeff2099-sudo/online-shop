//<?php

//namespace Controller;

//use Model\Cart;
//use Model\Order;
//use Model\OrderProduct;

//class OrderController
{
 //   public function getCheckoutForm()
    {
        require_once "./../Views/order_form.php";
    }

 //   public function handleCheckout()
    {
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }

        if (!isset($_SESSION['userId'])){
            header("Location: /login");
            exit;
        }

        $errors = $this->validate($_POST);

        if(empty($errors)) {
            $contactName = $_POST['contact_name'];
            $contactPhone = $_POST['contact_phone'];

            $contactPhone = preg_replace('/[^0-9+]/', '',$contactPhone);  // убираем лишние скобки, дефисы, тире с номера
            $contactPhone = preg_replace('/(?!^)\+/', '',$contactPhone); // убираем лишний + если есть, для сохранения в БД чистого номера только с одним +

            $comment = $_POST['comment'];
            $address = $_POST['address'];
            $userId = $_SESSION['userId'];

            $orderModel = new Order();
            $orderId = $orderModel->create($contactName, $contactPhone, $comment, $address, $userId);

            $userProductModel = new Cart();
          //  $userProducts = $userProductModel->getAllProductsByUserId($userId);

            $orderProduct = new OrderProduct();
            foreach ($userProducts as $userProduct) {
                $productId = $userProduct['product_id'];
                $amount = $userProduct['amount'];
                $orderProduct->create($orderId, $productId, $amount);

            }

           // $userProductModel->deleteByUserId($userId);

           // header("Location: /create-order");
        } else {
            require_once "./../Views/order_form.php";
        }

    }
   // private function validate(array $data): array
    {
        $errors = [];

        mb_internal_encoding("UTF-8");

        if (isset($data['contact_name'])) {
            $name = trim($data['contact_name']);

            // Убираем лишние пробелы (Иван   Петров → Иван Петров)
            $name = preg_replace('/\s+/u', ' ', $name);

            if ($name === '') {
                $errors['contact_name'] = "Имя должно быть заполнено";
            }
            elseif (mb_strlen($name) < 2) {
                $errors['contact_name'] = "Имя должно быть не короче 2 символов";
            }
            elseif (mb_strlen($name) > 50) {
                $errors['contact_name'] = "Имя слишком длинное";
            }
            // Только буквы, пробелы и дефисы
            elseif (!preg_match('/^[\p{L}\s\-]+$/u', $name)) {
                $errors['contact_name'] = "Только буквы, пробел и дефис";
            }
            // Запрещаем двойные дефисы или пробелы подряд
            elseif (preg_match('/[\s\-]{2,}/u', $name)) {
                $errors['contact_name'] = "Нельзя использовать подряд пробелы или дефисы";
            }
            // Дефис или пробел не в начале и не в конце
            elseif (preg_match('/^[\s\-]|[\s\-]$/u', $name)) {
                $errors['contact_name'] = "Имя не должно начинаться или заканчиваться пробелом или дефисом";
            }
            else {
                // ✅ Нормализация (делаем красиво)
                $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
            }

        } else {
            $errors['contact_name'] = "Имя должно быть заполнено";
        }

        if (isset($data['contact_phone'])) {
            $phone = $data['contact_phone'];
            if (!preg_match('/^\+?[0-9\s\-\(\)]{6,20}$/', $phone)) {
                $errors['contact_phone'] = "телефон некорректный";
            }
        } else {
            $errors['contact_phone'] = "Номер телефона должен быть заполнен";
        }
        //  проверка совпадения паролей

        if (isset($data['address'])) {
            $address = $data['address'];
            if (strlen($address) < 10) {
                $errors['address'] = 'Слишком короткий адрес';
            }
        } else {
            $errors['address'] = 'Адрес должен быть заполнен';
        }

        if (isset($data['comment'])) {
            $comment = $data['comment'];
            if (strlen($comment) > 255) {
                $errors['comment'] = 'Слишком длинный комментарий';
            }
        }

        return $errors;

    }
}