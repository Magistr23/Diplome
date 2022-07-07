<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function my_autoloader($users)
{
    include_once 'type/class/' . $users . '.php';
}

spl_autoload_register('my_autoloader');

$reg = new Users();

if (isset($_POST['entrance_aut'])) {
    $aut = new Users();
    $aut->check($_POST);
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="type/css/main.css" type="text/css">
    <title>Авторизация</title>
</head>
<body>
<div>
<header>
    <div>
        <h1>Добро пожаловать в облачное хранилище Полярность.</h1>
    </div>
</header>
    <div class="form">
<div class="container">
    <form action="index.php" method="post">
        <input type="text" name="login" placeholder="Введите логин">
        <input type="password" name="password" placeholder="Введите пароль">
        <input type="submit" name="entrance_aut" value="Войти">
        <a href="type/view/Recovery.php">Забыл пароль</a>
        <a href="type/view/registration.php">Зарегестрироваться</a>
    </form>
    <?php

    if (isset($_SESSION['message'])) {
        echo '<div class="msg">' . $_SESSION['message'] . '</div>';
    } /*elseif ($_SESSION['empty']) {
        echo '<div class="msg">' . $_SESSION['empty'] . '</div>';
    }*/

    unset($_SESSION['message']);
    unset($_SESSION['empty']);

    ?>
</div>
    </div>
</div>
</body>
</html>
