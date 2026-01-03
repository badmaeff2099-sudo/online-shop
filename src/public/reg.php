<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>My Great Work</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- Навигация -->
    <nav class="top-nav">
        <span class="logo">My Great Work</span>
        <a href="#">Рейтинг</a>
    </nav>

    <!-- Основной блок -->
    <div class="main">

        <!-- Левая панель -->
        <div class="left">

            <div class="profile">
                <div class="nickname">boris</div>
                <div class="rank">🛠 Рабочий режим</div>
                <div class="goal">
                    Цель: каждый день работать над проектом
                </div>
            </div>

            <button class="mark-btn">
                Отметить день
            </button>

            <div class="hint">
                Один шаг в день. Этого достаточно.
            </div>

        </div>

        <!-- Колонка пути -->
        <div class="path">

            <div class="column">

                <!-- квадраты (пример: 12 дней пройдено) -->
                <!-- нижние заполнены -->
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>
                <div class="square filled"></div>

                <!-- текущий день -->
                <div class="square today"></div>

                <!-- будущие -->
                <!-- (укорочено для примера) -->
                <div class="square"></div>
                <div class="square"></div>
                <div class="square"></div>
                <div class="square"></div>
                <div class="square"></div>

            </div>

        </div>

    </div>

</div>

<!-- счётчик визитов -->
<div class="visits">
    Сегодня на пути: 37
</div>

</body>
</html>

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #0f0f0f;
        color: #e0e0e0;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 16px;
    }

    /* Навигация */
    .top-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo {
        font-size: 14px;
        letter-spacing: 1px;
        color: #9adfa8;
    }

    .top-nav a {
        font-size: 13px;
        color: #aaa;
        text-decoration: none;
    }

    .top-nav a:hover {
        color: #fff;
    }

    /* Основной layout */
    .main {
        display: flex;
        gap: 40px;
    }

    /* Левая панель */
    .left {
        width: 260px;
    }

    .profile {
        margin-bottom: 14px;
    }

    .nickname {
        font-size: 16px;
        font-weight: bold;
    }

    .rank {
        font-size: 13px;
        color: #9adfa8;
        margin-top: 4px;
    }

    .goal {
        font-size: 12px;
        color: #bbb;
        margin-top: 8px;
        line-height: 1.4;
    }

    /* Кнопка */
    .mark-btn {
        margin-top: 16px;
        padding: 8px 14px;
        background: #1f3d2b;
        color: #dfffe8;
        border: 1px solid #2e6b4f;
        cursor: pointer;
    }

    .mark-btn:hover {
        background: #255b3e;
    }

    .hint {
        font-size: 10px;
        color: #666;
        margin-top: 6px;
    }

    /* Путь */
    .path {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .column {
        display: flex;
        flex-direction: column-reverse;
        gap: 4px;
    }

    /* Квадраты */
    .square {
        width: 18px;
        height: 18px;
        background: #222;
    }

    .square.filled {
        background: #3fa76a;
    }

    .square.today {
        background: #1f3d2b;
        outline: 1px dashed #4caf50;
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
        0% { opacity: 0.6; }
        50% { opacity: 1; }
        100% { opacity: 0.6; }
    }

    /* Счётчик визитов */
    .visits {
        position: fixed;
        bottom: 10px;
        right: 12px;
        font-size: 10px;
        color: #555;
        opacity: 0.7;
    }

</style>
