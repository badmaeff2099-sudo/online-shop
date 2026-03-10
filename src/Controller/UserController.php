<?php
namespace Controller;
use Model\User;

class UserController
{

    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function getRegistrate()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header("Location: /catalog");
        }
        require_once '../Views/registration_form.php';
    }

    public function registrate()
    {
        $errors = $this->validate($_POST);
        // внесение в БД, если нет ошибок

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRep = $_POST['psw-rep'];
            $password = password_hash($password, PASSWORD_DEFAULT);

         
            $user = $this->userModel->insertUsers($name, $email, $password); // добавление пользователя


            $result = $this->userModel->getByEmail($email);// для вывода данных зарегистрированного пользователя на экран

            print_r($result);
        }

        require_once '../Views/registration_form.php';


    }

    private function validate(array $data): array
    {
        $errors = [];

        // объявление и валидация данных

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно быть больше 2 символов";
            }
        } else {
            $errors['name'] = "Имя должно быть заполнено";
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 2) {
                $errors['email'] = "Почта должна быть больше 2 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "email некорректный";
            } else {
                // соединение с БД
             
                $user = $this->userModel->getByEmail($email);
                if ($user !== false) {
                    $errors['email'] = "Этот Email уже зарегистрирован";
                }
            }
        } else {
            $errors['email'] = "Почта должна быть заполнена";
        }

        //  проверка совпадения паролей

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (strlen($password) < 2) {
                $errors['psw'] = 'пароль должен быть больше 2';
            }
            $passwordRep = $data["psw-rep"];
            if ($password !== $passwordRep) {
                $errors['psw-rep'] = 'пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'Пароль должен быть заполнен';
        }


        return $errors;
    }

    public function getProfile()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        }
        require_once '../Views/profile_page.php';
    }

    public function profile()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];

          //  require_once '../Model/User.php';
         //   $userModel = new User();

            $user = $this->userModel->getById($userId); // getById

            require_once '../Views/profile_page.php';
        } else {
            header("Location: /login");

        }
    }

    public function getLogin()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header("Location: /catalog");
        }
        require_once '../Views/login_form.php';
    }

    public function login()
    {
        $errors = $this->validateLogin($_POST);

        if (empty($errors)) {

            $username = $_POST['username'];
            $password = $_POST['password'];


           // require_once '../Model/User.php';
          //  $userModel = new User();
            $user = $this->userModel->getByEmail($username);

            if (!empty($user)) {
                $passwordDb = $user['password'];

                if (password_verify($password, $passwordDb)) {

                    // успешный вход через сессии
                    session_start();
                    $_SESSION['userId'] = $user['id'];

                    header("Location: /catalog");

                } else {
                    $errors['username'] = 'username or password incorrect';
                }
            } else {
                $errors['username'] = 'Пользователя с таким логином не существует.';
            }
        }


        require_once '../Views/login_form.php';
    }

    private function validateLogin(array $data): array
    {
        $errors = [];
        if (!isset($data['username'])) {
            $errors['username'] = "Поле Username обязательно для заполнения!";
        }

        if (!isset($data['password'])) {
            $errors['password'] = "Поле Password обязательно для заполнения!";
        }
        return $errors;
    }

    public function getEditProfile()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location: /catalog");
        }
        require_once '../Views/edit_profile_form.php';
    }

    public function editProfile()
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {

            header("Location: /login");
            exit;
        }


        $errors = $this->validateEditProfile($_POST);


        if (empty($errors)) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $userId = $_SESSION['userId'];

          //  require_once '../Model/User.php';
         //   $userModel = new User();

            /*$pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->query("SELECT * FROM users WHERE id =" . $userId);
            $user = $stmt->fetch(); */

            $user = $this->userModel->getById($userId); // getById

            if ($user['name'] !== $name) {
               $this->userModel->updateNameById($name, $userId);

            }

            if ($user['email'] !== $email) {
                $this->userModel->updateEmailById($email, $userId);
            }
            header("Location: /profile");
            exit;
        }


        require_once '../Views/edit_profile_form.php';
    }

    private function validateEditProfile(array $data): array
    {
        $errors = [];

        // объявление и валидация данных

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно быть больше 2 символов";
            }
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 2) {
                $errors['email'] = "Почта должна быть больше 2 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "email некорректный";
            } else {
                // соединение с БД

              //  require_once '../Model/User.php';
              //  $userModel = new User();
                $user = $this->userModel->getByEmail($email);

                $userId = $_SESSION['userId'];
                if ($user && $user['id'] !== $userId) {
                    $errors['email'] = "Этот Email уже зарегистрирован!";
                }
            }
        }


        return $errors;
    }
}