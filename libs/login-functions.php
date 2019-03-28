<?php
function isUserAuthenticated($email, $password)
{
    global $pdo;

    $sql = 'SELECT `id`, `username`, `email` from `users` where `email`=:email AND `password`=:password';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':email' => $email,
        ':password' => md5($password)
    ]);
    $user = $statement->fetch();
    dump($user);
    exit;
}

function getUserByEmailAndPassword($email, $password)
{
    global $pdo;

    $sql = 'SELECT `id`, `username`, `email` from `users` where `email`=:email AND `password`=:password';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':email' => $email,
        ':password' => md5($password)
    ]);
    $user = $statement->fetch();
    return $user;
}

function saveUserTokenToDB($token, $userId)
{
    global $pdo;

    $sql = 'UPDATE `users` SET `token`=:token WHERE `id`=:userId';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':token' => md5($token),
        'userId' => $userId
        ]);
}

function getUserByToken($token)
{
    global $pdo;

    $sql = 'SELECT `id`, `username`, `email` from `users` where `token`=:token';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':token' => md5($token)
    ]);
    $user = $statement->fetch();
    return $user;
}

function clearUserToken($userId)
{
    global $pdo;

    $sql = 'UPDATE `users` SET `token`="" WHERE `id`=:userId';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'userId' => $userId
    ]);
}
