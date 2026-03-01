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

<a href="/profile" class="profile-link">
    👤 Мой профиль
</a>

<div class="catalog-container">

    <div class="catalog-title">
        Корзина
    </div>

    <!-- таблица отдельно -->
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
            </tr>
            </thead>

            <tbody>

            <?php if (!empty($products)): ?>

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

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="6" style="text-align:center; padding:40px;">
                        Корзина пуста
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

    <!-- общая сумма теперь полностью отдельно -->
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
        padding: 30px 20px;
    }

    .profile-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 14px;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
    }

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

    /* отдельный контейнер таблицы */
    .cart-table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        overflow: hidden;
    }

    /* таблица */
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

    /* отдельный контейнер общей суммы */
    .cart-summary-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    /* отдельный блок */
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

</style>