<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/app-config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/login-functions.php');

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

$user = getUserByEmailAndPassword($email, $password);
if (!$user) {
    $errorMessage = 'Неверный логин или пароль';
    include 'errors.php';
    exit;
}

//Записываем данные о зарегистрированном пользователе в сессию
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];

//TODO Реализация режима "Запомнить меня"
// Если выбран чек-бокс remember-me
// Сгенерировать токен

// Записать токен в куку (http only, срок жизни 10 дней)
// setcookie

//переадресовываем на главную
header('Location: /index.php');
exit;
