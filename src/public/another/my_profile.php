<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой профиль</title>

</head>
<body>

<div class="profile-card">
    <h1>Мой профиль</h1>

    <div class="profile-item">
        <label for="name">Имя</label>
        <input type="text" id="name" value="Иван Иванов" readonly>
    </div>

    <div class="profile-item">
        <label for="email">Почта</label>
        <input type="email" id="email" value="ivan@email.com" readonly>
    </div>

    <div class="profile-item">
        <label for="password">Пароль</label>
        <input type="password" id="password" value="12345678" readonly>
    </div>
</div>

</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .profile-card {
        background-color: #ffffff;
        padding: 25px 30px;
        width: 320px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-card h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-item {
        margin-bottom: 15px;
    }

    .profile-item label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .profile-item input {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
</style>