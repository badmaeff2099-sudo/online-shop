<?php
namespace Controller;
class LogoutController
{
    public function logout(): void
    {
        session_start();
        session_destroy();

        header("Location: /login");
        exit;

    }

}


