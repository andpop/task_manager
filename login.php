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

// Реализация режима "Запомнить меня"
if (isset($_POST['remember-me'])) {
    $token = getNewToken();
    saveTokenToCookie($token);
    saveUserTokenToDB($token, $user['id']);
} else {
    clearUserToken($user['id']);
    // Удаляем куку auth_token
    setcookie('auth_token');
}

//переадресовываем на главную
redirect('/index.php');
