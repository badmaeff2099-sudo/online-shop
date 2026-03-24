<?php

$cartTotal = 0;
foreach ($products as $product) {
    $cartTotal += $product['totalPrice'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
</head>
<body>
<?php if (!empty($_SESSION['success'])): ?>
    <div id="toast" class="toast show">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<div class="top-bar">

    <div class="left-buttons">
        <a href="/profile" class="profile-link">
            👤 Мой профиль
        </a>

        <a href="/catalog" class="cart-link">
            Каталог
        </a>

        <a href="/user-orders" class="cart-link">
            Мои заказы
        </a>
    </div>

    <a href="/logout" class="logout-link">
        Выйти
    </a>

</div>

<div class="catalog-container">

    <div class="catalog-title">
        Корзина
    </div>

    <div class="cart-table-container">

        <table class="cart-table">

            <thead>
            <tr>
                <th>Товар</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th>Добавить</th>
            </tr>
            </thead>

            <tbody>

            <?php foreach ($products as $product): ?>

                <tr>

                    <td class="image-cell">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>">
                    </td>

                    <td class="name-cell">
                        <?= htmlspecialchars($product['name']) ?>
                    </td>

                    <td class="description-cell">
                        <?= htmlspecialchars($product['description']) ?>
                    </td>

                    <td class="price-cell">
                        <?= number_format($product['price'], 0, '.', ' ') ?> ₽
                    </td>

                    <td class="amount-cell">
                        <?= $product['amount'] ?>
                    </td>

                    <td class="total-cell">
                        <?= number_format($product['totalPrice'], 0, '.', ' ') ?> ₽
                    </td>

                    <td class="update-cell">

                        <form action="update-cart" method="POST" class="update-form">

                            <input type="hidden" name="product_id"
                                   value="<?= $product['id'] ?>">

                            <input type="number"
                                   name="amount"
                                   value="<?= $product['amount'] ?>"
                                   min="1"
                                   class="update-input">

                            <button type="submit" class="update-btn">
                                ✔
                            </button>

                        </form>
                        <form action="/delete-product" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="delete-btn" title="Удалить товар">
                                ❌
                            </button>
                        </form>
                    </td>


                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div class="cart-summary-container">

        <div class="cart-total-box">

            <div class="cart-total-label">
                Общая сумма:
            </div>

            <div class="cart-total-price">
                <?= number_format($cartTotal, 0, '.', ' ') ?> ₽
            </div>

        </div>

    </div>
    <?php if (!empty($products)): ?>
        <a href="/create-order" class="checkout-form">
            <button type="button" class="checkout-btn">
                Оформить заказ
            </button>
        </a>
    <?php else: ?>
        <div class="empty-cart-box">
            <div class="empty-text">
                🛒 Добавьте товары в корзину
            </div>

            <a href="/catalog" class="go-catalog-btn">
                Перейти в каталог
            </a>
        </div>
    <?php endif; ?>
</div>
<script>
    const toast = document.getElementById('toast');

    if (toast) {
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
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
        min-height: 100vh;
        padding: 30px 20px;
    }

    /* ===== TOP BAR ===== */

    .top-bar {
        max-width: 1200px;
        margin: 0 auto 30px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .left-buttons {
        display: flex;
        gap: 15px;
    }

    .profile-link,
    .logout-link,
    .cart-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 14px;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
        transition: 0.2s;
    }

    .profile-link:hover,
    .logout-link:hover,
    .cart-link:hover {
        transform: translateY(-2px);
    }

    /* ===== CATALOG ===== */

    .catalog-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .catalog-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .cart-table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        overflow: hidden;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table thead {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .cart-table th {
        padding: 16px;
        text-align: left;
    }

    .cart-table td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .cart-table tbody tr:hover {
        background: #f8fafc;
    }

    .image-cell img {
        width: 70px;
        height: 70px;
        object-fit: contain;
        background: #f8fafc;
        border-radius: 10px;
        padding: 5px;
    }

    .name-cell {
        font-weight: 600;
    }

    .description-cell {
        color: #64748b;
    }

    .price-cell {
        font-weight: 600;
        color: #4f46e5;
    }

    .amount-cell {
        font-weight: 600;
    }

    .total-cell {
        font-weight: 700;
        color: #e53e3e;
    }
    .update-cell {
        width: 200px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .update-cell form {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin: 0;
    }

    .update-input {
        width: 85px;
        height: 30px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        text-align: center;
    }

    .update-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
    }

    .update-btn:hover {
        transform: scale(1.08);
    }

     /* ===== TOTAL ===== */

    .cart-summary-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .cart-total-box {
        background: white;
        padding: 20px 30px;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        min-width: 260px;
    }

    .cart-total-label {
        font-size: 14px;
        color: #64748b;
    }

    .cart-total-price {
        font-size: 28px;
        font-weight: 700;
        color: #4f46e5;
        margin-top: 5px;
    }
    .delete-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: #ef4444;
        color: white;
        font-size: 14px;
        cursor: pointer;
        transition: 0.2s;
    }

    .delete-btn:hover {
        background: #dc2626;
        transform: scale(1.08);
    }

    .update-cell form + form {
        margin-left: 4px;
    }
    .checkout-form {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
        text-decoration: none;
    }

    .checkout-btn {
        width: 260px;
        padding: 20px;
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
    /* ===== EMPTY CART ===== */

    .empty-cart-box {
        margin-top: 10px;
        width: 260px;
        padding: 18px;
        border-radius: 12px;

        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;

        box-shadow: 0 6px 18px rgba(0,0,0,0.12);

        margin-left: auto;

        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: center;

        animation: fadeSlide 0.4s ease;
    }

    .empty-text {
        font-size: 14px;
        font-weight: 600;
    }

    /* кнопка перехода */

    .go-catalog-btn {
        width: 100%;
        padding: 10px;
        text-align: center;

        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;

        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;

        transition: 0.2s;
    }

    .go-catalog-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(102,126,234,0.3);
    }

    /* анимация */

    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* ===== TOAST ===== */

    .toast {
        position: fixed;

        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-20px);

        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;

        padding: 14px 24px;
        border-radius: 12px;

        font-size: 14px;
        font-weight: 600;
        text-align: center;

        box-shadow: 0 10px 25px rgba(0,0,0,0.2);

        opacity: 0;
        transition: 0.3s ease;

        z-index: 9999;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
</style>