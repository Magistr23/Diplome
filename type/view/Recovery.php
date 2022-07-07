<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function my_autoloader($users)
{
    include_once '../class' . $users . '.php';
}

spl_autoload_register('my_autoloader');

if ($_POST['send']) {
    if ($_POST['password'] === $_POST['password2']) {

        $recovery = new Users();
        $recovery->updateLogin($_POST);
    } else {
        $_SESSION['password'] = 'Пароли не совпадают';
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Востановление пароля</title>
</head>
<body>
<div>
    <header>
        <div>
            <h1>Добро пожаловать в облачное хранилище Полярность.</h1>
        </div>
    </header>
    <div class="form">
        <div class="container_fix">
            <form action="../../index.php" method="post">
                <input type="text" name="login" placeholder="Введите логин">
                <input type="email" name="email" placeholder="Введите емайл">
                <input type="password" name="password" placeholder="Введите новый пароль">
                <input type="password" name="password2" placeholder="Повторите пароль">
                <input type="submit" name="send" value="Отправить">
                <a href="../../index.php">Зайти</a>
            </form>
            <?php
            if ($_SESSION['password']) {
                echo '<div class="msg">' . $_SESSION['password'] . '</div>';
            }
            unset($_SESSION['password']);
            ?>
        </div>
    </div>
</div>
</body>
</html>