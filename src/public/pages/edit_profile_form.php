<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: /login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Изменение профиля</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="profile-container">

    <!-- Кнопка назад -->
    <a href="/profile" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Вернуться в профиль
    </a>

    <!-- Карточка -->
    <div class="profile-card">
        <h1 class="page-title">
            <i class="fas fa-user-edit"></i>
            Изменение профиля
        </h1>

        <form action="profile-change" method="POST" class="profile-form">

            <div class="form-group">
                <label for="name">Имя</label>
                <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?php echo htmlspecialchars($user['name']); ?>"
                >
                <?php if (!empty($errors['name'])): ?>
                    <div class="error"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($user['email']); ?>"
                >
                <?php if (!empty($errors['email'])): ?>
                    <div class="error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i>
                Сохранить изменения
            </button>

        </form>
    </div>
</div>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    /* Контейнер */
    .profile-container {
        max-width: 600px;
        margin: 0 auto;
    }

    /* Кнопка назад */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding: 12px 22px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
        transition: 0.3s;
    }

    .back-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102,126,234,0.4);
    }

    /* Карточка */
    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    /* Заголовок */
    .page-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Форма */
    .profile-form {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 500;
        color: #4a5568;
    }

    .form-group input {
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        font-size: 16px;
        transition: 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
    }

    /* Ошибка */
    .error {
        color: #e53e3e;
        font-size: 14px;
    }

    /* Кнопка сохранить */
    .save-btn {
        margin-top: 10px;
        padding: 16px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(79,70,229,0.3);
        transition: 0.3s;
    }

    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79,70,229,0.4);
    }
</style>

</body>
</html>
