<?php
// предполагается что $errors приходит с сервера
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>

<body>

<div class="login-container">

    <div class="login-box">
        <h1 class="login-title">Вход</h1>

        <form action="/login" method="post" class="login-form">

            <input type="text" name="username" placeholder="Логин" class="login-input"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

            <?php if (!empty($errors['username'])): ?>
                <div class="error-text"><?= $errors['username']; ?></div>
            <?php endif; ?>

            <input type="password" name="password" placeholder="Пароль" class="login-input">

            <?php if (!empty($errors['password'])): ?>
                <div class="error-text"><?= $errors['password']; ?></div>
            <?php endif; ?>

            <button type="submit" class="login-btn">
                Войти
            </button>

        </form>

        <!-- регистрация -->
        <div class="register-block">
            <div class="register-text">
                Нет аккаунта?
            </div>

            <a href="/registration" class="register-btn">
                Зарегистрироваться
            </a>
        </div>

    </div>

</div>

</body>
</html>

<style>

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* контейнер */

    .login-container {
        width: 100%;
        max-width: 400px;
    }

    /* карточка */

    .login-box {
        background: white;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.15);
    }

    /* заголовок */

    .login-title {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 25px;

        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* форма */

    .login-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* инпуты */

    .login-input {
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        transition: 0.2s;
    }

    .login-input:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
    }

    /* кнопка входа */

    .login-btn {
        margin-top: 10px;
        padding: 14px;

        border: none;
        border-radius: 12px;

        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;

        font-size: 15px;
        font-weight: 600;

        cursor: pointer;
        transition: 0.2s;

        box-shadow: 0 5px 15px rgba(102,126,234,0.3);
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102,126,234,0.4);
    }

    .login-btn:active {
        transform: scale(0.97);
    }

    /* ошибки */

    .error-text {
        font-size: 13px;
        color: #ef4444;
        margin-top: -5px;
    }

    /* блок регистрации */

    .register-block {
        margin-top: 20px;
        text-align: center;
    }

    .register-text {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 10px;
    }

    /* кнопка регистрации */

    .register-btn {
        display: inline-block;
        padding: 10px 18px;

        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;

        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;

        transition: 0.2s;
    }

    .register-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(34,197,94,0.3);
    }

</style>