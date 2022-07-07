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

// Проверка на вход
if (!$_SESSION['user']) {
    header('Location: index.php');
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
    <title>Облачное хранилище</title>
</head>
<body>
<header>
    <div>
        <h1>Вас приветствует облачное хранилище Полярность <br> Рабочее место администратора</h1>
<div class="container">
    <form action="diplom.php" method="post">
        <a href="diplom.php">Назад</a>
        <a href="out.php">Выйти из аккаунта</a>
    </form>
</div>
</div>
</header>
<div class="container">
    <div class="body">
        <?php
            $users = new Users();
            if (isset($_POST['delete'])) {
                $users->deleteLogin($_POST);
                rmdir('../user/' . $_POST['login']);
            } elseif (isset($_POST['red'])) {
               $users->updateAdmin($_POST);
            }
            $user = $users->list();
        ?>
        <?php foreach ($user as $users): ?>
            <table>
                <tr>
                    <form action="admin.php" method="post">
                    <td><input class="fix" type="text" name="id" value="<?=$users['id']?>"></td>
                    <td><input class="fix" type="text" name="login" value="<?=$users['login']?>"></td>
                    <td><input class="fix" type="text" name="email" value="<?=$users['email']?>"></td>
                    <td><input class="fix" type="text" name="role" value="<?=$users['role']?>"></td>
                    <td><input class="fix" type="submit" name="delete" value="Удалить"></td>
                    <td><input class="fix" type="submit" name="red" value="Редактировать"></td>
                    </form>
                </tr>
            </table>
        <?php endforeach; ?>
        <table>
            <tr>
                <td></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
