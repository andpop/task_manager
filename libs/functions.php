<?php
require_once 'connection-params.php';

function dump($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function redirect($link)
{
    header("Location: $link");
    exit;
}

function dbConnect()
{
    $connectionString = 'mysql:host=' . CONNECT_DB['host'] . ';dbname=' . CONNECT_DB['database'].';';
    $pdoOptions = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false
    ];
    return new PDO($connectionString, CONNECT_DB['user'], CONNECT_DB['password'], $pdoOptions);
}

// Валидация входных данных (проверка на пустые значения)
function isEmptyFieldInPost() : bool
{
    foreach ($_POST as $postItem) {
        if (empty(trim($postItem))) {
            return true;
        }
    }
    return false;
}

function getNewToken() : string
{
    return bin2hex(random_bytes(64));
}

function saveTokenToCookie($token)
{
    $expirationTime = time()+60*60*24*10;
    setcookie('auth_token', $token, $expirationTime, "", "", false, true);
}
