<?php
error_reporting(E_ALL);

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Проверка поступивших из формы данных на пустоту
foreach ($_POST as $postItem) {
    if (empty(trim($postItem))) {
        $errorMessage = 'Все поля должны быть заполнены!';
        include 'errors.php';
        exit;
    }
}

// Подключение к БД
define('CONNECT_DB', [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '12345678',
    'database' => 'task-manager'
]);
$connectionString = 'mysql:host=' . CONNECT_DB['host'] . ';dbname=' . CONNECT_DB['database'].';';
$pdo = new PDO($connectionString, CONNECT_DB['user'], CONNECT_DB['password']);

// Проверка существования пользователя в БД
$sql = 'SELECT id FROM users WHERE email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetchColumn();
if ($user) {
    $errorMessage = "Ошибка! Пользователь с почтовым адресом {$email} уже зарегистрирован.";
    include 'errors.php';
    exit;
}

// Вставка в БД записи о новом пользователе
$passwordHash = md5($password);
$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email, ':username' => $username, ':password' => $passwordHash]);

// Переадресация на форму для логина
header('Location: /login-form.php');
