<?php

// Проверка существования email пользователя в БД
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
