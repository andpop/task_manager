<?php
require_once 'connection-params.php';

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

function isEmptyFieldInPost()
{
    foreach ($_POST as $postItem) {
        if (empty(trim($postItem))) {
            return true;
        }
    }
    return false;
}

function isUserEmailExists($email)
{
    global $pdo;

    $sql = 'SELECT id FROM users WHERE email=:email';
    $statement = $pdo->prepare($sql);
    $statement->execute([':email' => $email]);
    $user = $statement->fetchColumn();

    return $user ? true : false;
}

// Вставка в БД записи о новом пользователе
function saveNewUser($username, $email, $password)
{
    global $pdo;

    $passwordHash = md5($password);
    $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
    $statement = $pdo->prepare($sql);
    $statement->execute([':email' => $email, ':username' => $username, ':password' => $passwordHash]);
}
