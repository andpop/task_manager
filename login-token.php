<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/app-config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/login-functions.php');

$token = $_COOKIE['auth_token'];
// Подключение к БД
$pdo = dbConnect();
if (!$pdo) {
    exit;
}

$user = getUserByToken($token);
//Если пользователь по токену не найден, то перенаправляем на форму входа
if (!$user) {
    redirect('/login-form.php');
}

//Записываем данные о зарегистрированном пользователе в сессию
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];

//Обновляем токен в базе и в куках
//echo $token . '<br>';
$token = getNewToken();
saveTokenToCookie($token);
saveUserTokenToDB($token, $user['id']);
//echo $token . '<br>';

//переадресовываем на главную
redirect('/index.php');
