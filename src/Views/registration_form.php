<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>

<body>

<div class="register-container">

    <div class="register-box">

        <h1 class="register-title">Регистрация</h1>

        <form action="/registration" method="POST" class="register-form">

            <!-- NAME -->
            <input type="text" name="name" placeholder="Имя" class="register-input"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

            <?php if (!empty($errors['name'])): ?>
                <div class="error-text"><?= $errors['name']; ?></div>
            <?php endif; ?>


            <!-- EMAIL -->
            <input type="text" name="email" placeholder="Email" class="register-input"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <?php if (!empty($errors['email'])): ?>
                <div class="error-text"><?= $errors['email']; ?></div>
            <?php endif; ?>


            <!-- PASSWORD -->
            <div class="password-wrapper">
                <input type="password" name="psw" placeholder="Пароль"
                       class="register-input" id="password">

                <button type="button" class="toggle-password"
                        onclick="togglePassword('password', this)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6S2 12 2 12Z" stroke="black" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="3" stroke="black" stroke-width="1.5"/>
                    </svg>
                </button>
            </div>

            <?php if (!empty($errors['psw'])): ?>
                <div class="error-text"><?= $errors['psw']; ?></div>
            <?php endif; ?>


            <!-- REPEAT PASSWORD -->
            <div class="password-wrapper">
                <input type="password" name="psw-rep" placeholder="Повторите пароль"
                       class="register-input" id="password2">

                <button type="button" class="toggle-password"
                        onclick="togglePassword('password2', this)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6S2 12 2 12Z" stroke="black" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="3" stroke="black" stroke-width="1.5"/>
                    </svg>
                </button>
            </div>

            <?php if (!empty($errors['psw-rep'])): ?>
                <div class="error-text"><?= $errors['psw-rep']; ?></div>
            <?php endif; ?>


            <button type="submit" class="register-btn">
                Зарегистрироваться
            </button>

        </form>

        <!-- КНОПКА ВОЙТИ -->
        <div class="login-block">
            <div class="login-text">Уже есть аккаунт?</div>

            <a href="/login" class="login-btn">
                Войти
            </a>
        </div>

    </div>

</div>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const svg = btn.querySelector("svg");

        if (input.type === "password") {
            input.type = "text";

            // зачёркнутый глаз
            svg.innerHTML = `
            <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6S2 12 2 12Z" stroke="black" stroke-width="1.5"/>
            <line x1="3" y1="3" x2="21" y2="21" stroke="black" stroke-width="1.5"/>
        `;
        } else {
            input.type = "password";

            // обычный глаз
            svg.innerHTML = `
            <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6S2 12 2 12Z" stroke="black" stroke-width="1.5"/>
            <circle cx="12" cy="12" r="3" stroke="black" stroke-width="1.5"/>
        `;
        }
    }
</script>

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

    .register-container {
        width: 100%;
        max-width: 420px;
    }

    .register-box {
        background: white;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.15);
    }

    .register-title {
        text-align: center;
        font-size: 28px;
        margin-bottom: 25px;
        font-weight: 700;
    }

    .register-form {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .register-input {
        width: 100%;
        padding: 14px 45px 14px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
    }

    .error-text {
        font-size: 13px;
        color: #ef4444;
        margin-top: -5px;
        margin-bottom: 5px;
    }

    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        opacity: 0.6;
    }

    .toggle-password:hover {
        opacity: 1;
    }

    /* ===== Динамические кнопки с эффектом всплытия ===== */

    .register-btn {
        margin-top: 10px;
        padding: 14px;
        border: none;
        border-radius: 12px;

        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;

        font-weight: 600;
        cursor: pointer;

        transition: 0.2s;
        box-shadow: 0 5px 15px rgba(34,197,94,0.3);
    }

    .register-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(34,197,94,0.4);
    }

    .register-btn:active {
        transform: scale(0.97);
    }

    .login-block {
        margin-top: 20px;
        text-align: center;
    }

    .login-text {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .login-btn {
        display: inline-block;
        padding: 10px 18px;

        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;

        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;

        transition: 0.2s;
        box-shadow: 0 4px 12px rgba(102,126,234,0.3);
    }

    .login-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(102,126,234,0.4);
    }

    .login-btn:active {
        transform: scale(0.97);
    }

</style>