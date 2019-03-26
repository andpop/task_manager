<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/app-config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/register-functions.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Проверка поступивших из формы данных на пустоту
if (isEmptyFieldInPost()) {
    $errorMessage = 'Все поля должны быть заполнены!';
    include 'errors.php';
    exit;
}

// Подключение к БД
$pdo = dbConnect();
if (!$pdo) {
    exit;
}

if (isUserEmailExists($email)) {
    $errorMessage = "Ошибка! Пользователь с почтовым адресом {$email} уже зарегистрирован.";
    include 'errors.php';
    exit;
}

saveNewUser($username, $email, $password);

// Переадресация на форму для логина
header('Location: /login-form.php');
