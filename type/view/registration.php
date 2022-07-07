<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function my_autoloader($users)
{
    include_once '../class/' . $users . '.php';
}

spl_autoload_register('my_autoloader');

$reg = new Users();
if (isset($_POST['reg'])) {
    if ($_POST['password'] === $_POST['password2']) {
        $reg->createLogin($_POST);
        mkdir('../user/' . $_POST['login'], 0700);
        $_SESSION['user'] = ["login" => $_POST['login']];
        header('location: diplom.php');
    } else {
        $_SESSION['Password'] = 'Пароли не совпадают';
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
    <title>Регистрация</title>
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
            <form action="registration.php" method="post">
                <input type="text" name="login" placeholder="Введите логин">
                <input type="email" name="email" placeholder="Введите почту">
                <input type="password" name="password" placeholder="Введите пароль">
                <input type="password" name="password2" placeholder="Повторите пароль123">
                <input type="submit" name="reg" value="Зарегестрироваться">
            </form>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="msg">' . $_SESSION['message'] . '</div>';
            } elseif (isset($_SESSION['checkpassword'])) {
                echo '<div class="msg">' . $_SESSION['Password'] . '</div>';
            }
            unset($_SESSION['message']);
            unset($_SESSION['Password']);
            ?>
        </div>
    </div>
</div>
</body>
</html>