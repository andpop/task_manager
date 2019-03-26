<?php
function isUserAuthenticated($email, $password)
{
    global $pdo;

    $sql = 'SELECT id, username, email from users where email=:email AND password=:password';
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

    $sql = 'SELECT id, username, email from users where email=:email AND password=:password';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':email' => $email,
        ':password' => md5($password)
    ]);
    $user = $statement->fetch();
    return $user;
}
