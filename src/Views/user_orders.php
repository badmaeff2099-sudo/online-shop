<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои заказы</title>
</head>
<body>

<div class="top-bar">
    <div class="left-buttons">
        <a href="/profile" class="profile-link">👤 Мой профиль</a>
        <a href="/catalog" class="cart-link">Каталог</a>
        <a href="/cart" class="cart-link">Корзина</a>
    </div>

    <a href="/logout" class="logout-link">Выйти</a>
</div>

<div class="catalog-container">

    <div class="catalog-title">
        Мои заказы
    </div>

    <div class="order-container">

        <?php foreach ($newUserOrders as $newUserOrder): ?>

            <div class="order-card">

                <div class="order-header">
                    <h2>Заказ № <?= $newUserOrder['id']; ?></h2>

                </div>

                <div class="order-info">
                    <p><strong>Имя:</strong> <?= $newUserOrder['contact_name']; ?></p>
                    <p><strong>Телефон:</strong> <?= $newUserOrder['contact_phone']; ?></p>
                    <p><strong>Адрес:</strong> <?= $newUserOrder['address']; ?></p>
                    <p><strong>Комментарий:</strong> <?= $newUserOrder['comment']; ?></p>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Кол-во</th>
                            <th>Цена</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($newUserOrder['products'] as $newOrderProduct): ?>
                            <tr>
                                <td><?= $newOrderProduct['name']; ?></td>
                                <td><?= $newOrderProduct['amount']; ?></td>
                                <td><?= number_format($newOrderProduct['price'], 0, '.', ' ') ?> ₽</td>
                                <td><?= number_format($newOrderProduct['totalSumOneProduct'], 0, '.', ' ') ?> ₽</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: 600;">
                                Общая сумма:
                            </td>
                            <td style="font-weight: 700; color: #22c55e;">
                                <?= number_format($newUserOrder['total'], 0, '.', ' ') ?> ₽
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

        <?php endforeach; ?>

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
        padding: 30px 20px;
    }

    /* TOP BAR */
    .top-bar {
        max-width: 1200px;
        margin: 0 auto 30px;
        display: flex;
        justify-content: space-between;
    }

    .left-buttons {
        display: flex;
        gap: 15px;
    }

    .profile-link,
    .cart-link,
    .logout-link {
        padding: 12px 24px;
        border-radius: 14px;
        text-decoration: none;
        color: white;
        background: linear-gradient(135deg, #667eea, #764ba2);
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
        transition: 0.2s;
    }

    .profile-link:hover,
    .cart-link:hover,
    .logout-link:hover {
        transform: translateY(-2px);
    }

    /* CONTAINER */
    .catalog-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .catalog-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 25px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ORDER CARD */
    .order-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .order-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    /* HEADER */
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .order-total {
        font-size: 20px;
        font-weight: 700;
        color: #22c55e;
    }

    /* INFO */
    .order-info {
        margin-bottom: 15px;
    }

    .order-info p {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 5px;
    }

    /* TABLE */
    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    th, td {
        padding: 14px;
        text-align: left;
    }

    tbody tr {
        border-bottom: 1px solid #eee;
    }

    tbody tr:hover {
        background: #f8fafc;
    }
    tfoot td {
        padding-top: 15px;
        border-top: 2px solid #eee;
    }
</style>
