<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="profile-container">
    <div class="profile-header">
        <div class="header-content">
            <button class="back-button" onclick="window.history.back()">
                <i class="fas fa-arrow-l eft"></i>
                <span>Назад в каталог</span>
            </button>
            <h1 class="page-title">Профиль пользователя</h1>
        </div>
    </div>

    <div class="profile-content">
        <div class="profile-card">
            <div class="profile-section">
                <h2 class="section-title">
                    <i class="fas fa-user"></i>
                    О пользователе
                </h2>

                <div class="profile-info">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-user-circle"></i>
                            <span>Имя:</span>
                        </div>
                        <div class="info-value"><?php echo $user['name']; ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            <span>Email:</span>
                        </div>
                        <div class="info-value"><?php echo $user['email']; ?> </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-globe"></i>
                            <span>Страна:</span>
                        </div>
                        <div class="info-value">
                            <span class="country-flag">🇷🇺</span>
                            Россия
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-actions">
                <button class="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    <a href="/profile-change">Изменить профиль</a>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Обработка нажатия кнопки "Изменить профиль"
    document.querySelector('.edit-profile-btn').addEventListener('click', function() {
        alert('Редактирование профиля - функционал в разработке');
        // Здесь можно добавить логику открытия формы редактирования
    });
</script>
</body>
</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        color: #333;
        line-height: 1.6;
    }

    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .profile-header {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        padding: 25px 30px;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .back-button {
        display: flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .back-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .back-button:active {
        transform: translateY(0);
    }

    .back-button i {
        font-size: 16px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .profile-content {
        display: flex;
        justify-content: center;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        width: 100%;
        max-width: 600px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .profile-section {
        padding: 40px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title i {
        color: #667eea;
        font-size: 26px;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .info-row:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateX(5px);
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        color: #4a5568;
        font-size: 16px;
    }

    .info-label i {
        color: #667eea;
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .info-value {
        font-size: 17px;
        font-weight: 600;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .country-flag {
        font-size: 20px;
    }

    .profile-actions {
        padding: 30px 40px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-top: 1px solid #e2e8f0;
        text-align: center;
    }

    .edit-profile-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        border: none;
        padding: 16px 36px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .edit-profile-btn:hover {
        background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }

    .edit-profile-btn:active {
        transform: translateY(0);
    }

    .edit-profile-btn i {
        font-size: 18px;
    }

</style>