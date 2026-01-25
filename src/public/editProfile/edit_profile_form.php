<?php

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['userId'])) {
$userId = $_SESSION['userId'];
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

    $stmt = $pdo->query('SELECT * FROM users');
    $user = $stmt->fetch();
} else{
    header("Location: /login");
}

?>

<form action="profile-change" method="POST" class="form-example">
    <div class="form-example">
        <label for="паме">Введите новое имя: </label>
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
    form.form-example{
        display: table;
    }

</style>
