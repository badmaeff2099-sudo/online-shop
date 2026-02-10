<form action="add-product" method="POST">
    <div class="page-container">

        <div class="form-card">
            <h1 class="form-title">
                <i class="fas fa-box"></i>
                Добавить товар в корзину
            </h1>

            <div class="form-group">
                <label for="product_id">ID товара</label>
                <input
                        type="text"
                        name="product_id"
                        id="product_id"
                        placeholder="Введите ID товара"
                        required
                >
                <?php if (isset($errors['product_id'])): ?>
                    <div class="error"><?php echo $errors['product_id']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="amount">Количество</label>
                <input
                        type="number"
                        name="amount"
                        id="amount"
                        placeholder="Введите количество"
                        min="1"
                        required
                >
                <?php if (isset($errors['amount'])): ?>
                    <div class="error"><?php echo $errors['amount']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-cart-plus"></i>
                Добавить товар
            </button>
        </div>

    </div>
</form>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        min-height: 100vh;
        padding: 40px 20px;
    }

    /* Контейнер */
    .page-container {
        max-width: 520px;
        margin: 0 auto;
    }

    /* Карточка формы */
    .form-card {
        background: white;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Заголовок */
    .form-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Группа поля */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #4a5568;
    }

    .form-group input {
        padding: 14px 16px;
        font-size: 16px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        transition: 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
    }

    /* Ошибки */
    .error {
        font-size: 14px;
        color: #e53e3e;
    }

    /* Кнопка */
    .submit-btn {
        margin-top: 10px;
        padding: 16px;
        border: none;
        border-radius: 16px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: 0 4px 15px rgba(79,70,229,0.3);
        transition: 0.3s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79,70,229,0.4);
    }
</style>