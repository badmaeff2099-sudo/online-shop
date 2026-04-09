<?php
$currentPage = $_SERVER['REQUEST_URI'] ?? '';
?>

<div class="top-bar">

    <div class="left-buttons">
        <a href="/profile"
           class="nav-link <?= str_contains($currentPage, '/profile') ? 'active-link' : '' ?>">
            👤 Мой профиль
        </a>

        <a href="/cart"
           class="nav-link <?= str_contains($currentPage, '/cart') ? 'active-link' : '' ?>">
            🛒 Корзина
            <?php if (isset($cartCount) && $cartCount > 0): ?>
                <span class="cart-badge"><?= $cartCount ?></span>
            <?php endif; ?>
        </a>
    </div>

    <a href="/logout" class="nav-link logout-link">
         Выйти
    </a>

</div>

<div class="catalog-container">
    <h1 class="catalog-title">Каталог товаров</h1>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <a href="#" class="product-card">
                <div class="product-badge">HIT</div>

                <div class="product-image">
                    <img src="<?php echo $product->getImageUrl(); ?>" alt="product">
                </div>

                <div class="product-info">
                    <span class="product-name">
                        <?php echo $product->getName(); ?>
                    </span>

                    <h3 class="product-description">
                        <?php echo $product->getDescription(); ?>
                    </h3>

                    <div class="product-price">
                        <?php echo $product->getPrice() ?> ₽
                    </div>

                </div>
            </a>

            <form action="add-product" method="POST">
                <div class="page-container">

                    <div class="form-card">
                        <h1 class="form-title">
                            <i class="fas fa-box"></i>
                            Добавить товар в корзину
                        </h1>

                        <div class="form-group">
                            <input
                                    type="hidden"
                                    name="product_id"
                                    id="product_id"
                                    value="<?php echo $product->getId(); ?>"
                                    required
                            >
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
        <?php endforeach; ?>
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

    .nav-link {
        position: relative;
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
        transition: 0.3s;
    }

    .nav-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102,126,234,0.4);
    }

    .active-link {
        box-shadow: 0 0 0 3px rgba(79,70,229,0.6);
    }

    .logout-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        box-shadow: 0 0 0 0 rgba(79,70,229,0.6);
    }

    .logout-link:hover {
        box-shadow: 0 6px 20px rgba(102,126,234,0.4);
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ffffff;
        color: #e53e3e;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 7px;
        border-radius: 50%;
        min-width: 20px;
        text-align: center;
    }

    /* ===== Каталог ===== */

    .catalog-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .catalog-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 30px;
    }

    .product-card {
        position: relative;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        text-decoration: none;
        color: #2d3748;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transition: 0.3s;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 14px 40px rgba(0,0,0,0.18);
    }

    .product-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, #f43f5e, #ec4899);
        color: white;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
        z-index: 2;
    }

    .product-image {
        height: 220px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: 0.3s;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .product-name {
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .product-description {
        font-size: 18px;
        font-weight: 600;
        line-height: 1.3;
    }

    .product-price {
        margin-top: 10px;
        font-size: 20px;
        font-weight: 700;
        color: #4f46e5;
    }

</style>