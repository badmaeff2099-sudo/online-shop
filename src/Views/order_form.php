<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оформление заказа</title>
</head>

<body>

<div class="order-container">

    <h2 class="order-title">Оформление заказа</h2>

    <form action="/create-order" method="POST">

        <div class="form-group">
            <label>Имя</label>
            <?php if (isset($errors['contact_name'])): ?>
                <label class="error"><?php echo $errors['contact_name']; ?></label>
            <?php endif; ?>
            <input type="text" name="contact_name" required>
        </div>

        <div class="form-group">
            <label>Номер телефона</label>
            <?php if (isset($errors['contact_phone'])): ?>
                <label class="error"><?php echo $errors['contact_phone']; ?></label>
            <?php endif; ?>
            <input type="tel" name="contact_phone" required>
        </div>

        <div class="form-group">
            <label>Адрес доставки</label>
            <?php if (isset($errors['address'])): ?>
                <label class="error"><?php echo $errors['address']; ?></label>
            <?php endif; ?>
            <input type="text" name="address" required>
        </div>

        <div class="form-group">
            <label>Комментарий к заказу</label>
            <?php if (isset($errors['comment'])): ?>
                <label class="error"><?php echo $errors['comment']; ?></label>
            <?php endif; ?>
            <textarea name="comment"></textarea>
        </div>

        <button type="submit" class="checkout-btn">
            Оформить заказ
        </button>

    </form>

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
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* ===== CONTAINER ===== */

    .order-container {
        background: white;
        padding: 30px;
        width: 420px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    /* ===== TITLE ===== */

    .order-title {
        text-align: center;
        margin-bottom: 25px;
        font-size: 26px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ===== FORM ===== */

    .form-group {
        margin-bottom: 18px;
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 6px;
        font-size: 14px;
        color: #64748b;
    }

    /* ошибки */
    .error {
        color: #ef4444;
        font-size: 13px;
        margin-bottom: 5px;
    }

    /* inputs */

    input,
    textarea {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        transition: 0.2s;
    }

    input:focus,
    textarea:focus {
        outline: none;
        border-color: #667eea;
    }

    textarea {
        resize: none;
        height: 90px;
    }

    /* ===== BUTTON ===== */

    .checkout-btn {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        box-shadow: 0 4px 12px rgba(34,197,94,0.3);
    }

    .checkout-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(34,197,94,0.4);
    }

    .checkout-btn:active {
        transform: scale(0.97);
    }

</style>