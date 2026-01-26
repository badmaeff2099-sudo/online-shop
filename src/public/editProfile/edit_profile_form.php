<?php

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['userId'])) {
$userId = $_SESSION['userId'];
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

    $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
    $user = $stmt->fetch();
} else{
    header("Location: /login");
}

?>

<form action="profile-change" method="POST" class="form-example">

    <div class="profile-actions">
        <button class="edit-profile-btn">
            <i class="fas fa-edit"></i>
            <a href="/profile">Вернуться в мой профиль</a>
        </button>
    </div>

    <div class="form-example">
        <label for="name">Введите новое имя: </label>
        <?php if (isset($errors['name'])): ?>
            <label style="color:red "><?php echo $errors['name'];?></label>
        <?php endif; ?>

        <input type="text" name="name" id="name" value="<?php echo $user['name'];?>" />
    </div>

    <div class="form-example">
        <label for="email">Введите новый еmail: </label>
        <?php if (isset($errors['email'])): ?>
            <label style="color:red "><?php echo $errors['email'];?></label>
        <?php endif; ?>
        <input type="email" name="email" id="email" value="<?php echo $user['email'];?>" />
    </div>

    <div class="form-example">
        <input type="submit" value="Изменить" />
    </div>
</form>
<style>
    .form-example{
        display: table;
        margin-bottom: 10px;
    }
    .profile-actions {

        margin-bottom: 10px;
    }


</style>
