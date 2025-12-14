<?php

# echo "Hello World!!!";

$pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

print_r($pdo);

$pdo->exec("INSERT INTO users (name, email, password) VALUES ('Ivan', 'ivan@email.com', 'qwerty123')");
$pdo->exec("DELETE FROM users WHERE id BETWEEN 3 AND 9");

$statement = $pdo->query("SELECT * FROM users");

$data = $statement->fetch();
echo "<pre>";
print_r($data);
echo "<pre>";



