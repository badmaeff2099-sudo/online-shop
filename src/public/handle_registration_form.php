<?php

print_r($_GET);

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$passwordRep = $_GET['psw-repeat'];


$errors = [];

if(isset($_GET['name'])){
    $name = $_GET['name'];

    if (strlen($name) < 2 ){
        $errors['name'] = 'имя должно быть больше 2';
    }
} else {
    $errors['name'] = 'Имя должно быть заполнено';
}



if (strlen($email) < 2 ){
    $errors['email'] = 'почта должна быть больше 2';
} elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
    $errors['email'] = 'email некорректный ';

}

if (strlen($password) < 2 ){
    $errors['psw'] = 'пароль должен быть больше 2';

}

if (strlen($passwordRep) < 2 ){
    $errors['psw'] = 'повторный пароль должен быть больше 2';

}

if($password !== $passwordRep){

    $errors['psw-rep'] = 'пароли не совпадают';
}

if (empty($errors)){
    $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pwd');

    $pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

} else {
    print_r($errors);
}

?>

<form action="handle_registration_form.php">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <label for="name"><b>Name</b></label>
        <label style = "color:red "><?php echo $errors['name']; ?> </label>
        <input type="text" placeholder="Enter Name" name="name" id="name" required>
        <label for="email"><b>Email</b></label>
        <?php echo $errors['email']; ?>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>
        <label for="psw"><b>Password</b></label>
        <?php echo $errors['psw']; ?>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
        <label for="psw-repeat"><b>Repeat Password</b></label>
        <?php echo $errors['psw-rep']; ?>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required> <hr>
        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p> <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>
<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA60;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey backround color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>


