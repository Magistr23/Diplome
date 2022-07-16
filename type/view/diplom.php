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

if (isset($_POST['delete_file'])) {
    $delete = new File();
    $delete->detFile($_POST['login']);
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
        <h1>Вас приветствует облачное хранилище Полярность <br> Вы вошли под логином  <?php echo $_SESSION['user']['login']?></h1>
        <div class="container">
            <form action="diplom.php" method="post">
                <a href="out.php">Выйти из аккаунта</a>
                <?php
                if (isset($_SESSION['admin']['login'])) {
                    echo '<a href="admin.php">Для администратора</a>';
                }
                ?>
            </form>
        </div>
    </div>
</header>
<div class="container">
    <div class="body">
    <?php
    // временно для проверки
    /*print_r($_POST);
    var_dump($_FILES);*/

    // Работа с аккаунтом
    // вывод информации о файлах
    try {
        if (isset($_POST['create'])) {
            mkdir('../user/' . $_SESSION['user']['login'] . $_POST['name'], 0700);
            echo "<br>" . 'Папка ' . $_POST['name'] . ' создана';
            $_SESSION['folder'] = $_POST['name'];
        } elseif (isset($_POST['delete']) && is_dir( '../user/' . $_SESSION['user']['login'] . '/' . $_POST['name'])) {
            rmdir('../user/' . $_SESSION['user']['login'] . '/' . $_POST['name']);
            echo "<br>" . 'Папка ' . $_POST['name'] . ' удалена';
            unset($_SESSION['folder']['name']);
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
    // Загрузка файлов
    if (isset($_POST['load'])) {
        $dir_file = '../user/' . $_SESSION['user']['login'] . '/';
        $uploadFile  = $dir_file . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $file = new File();
            $file->createFile($_FILES['file']['name'], $uploadFile, $_SESSION['user']['login']);
            echo 'Файл ' . $_FILES['file']['tmp_name'] . ' был успешно загружен';
        }

    }
    // Вывод файлов
    $list = new File();
    $listFile = $list->listFile();
    if (!empty($listFile)) {
        echo 'У вас уже загружено';
        foreach ($listFile as $list) {
            if ($list['login'] === $_SESSION['user']['login']) {
                echo '<form action="diplom.php" method="post">';
                echo '<input type="text" name="login" value="' . $list['name'] . '">';
                echo '<input type="submit" name="delete_file" value="Удалить">';
                echo '</form>';
            }
        }
    } else {
        echo 'У вас пока нет файлов';
    }
    ?>
    </div>
</div>
    <div class="container">
        <form action="diplom.php" method="post" enctype="multipart/form-data">
            <input type="text" name="login" placeholder="Введите логин человека">
            <input type="text" name="name" placeholder="Название папки или файла">
            <input type="file" name="file">
            <label>Выберите действие</label>
            <input type="submit" name="load" value="Загрузить">
            <input type="submit" name="create" value="Создать папку">
            <input type="submit" name="delete" value="Удалить папку">
            <input type="submit" name="transfer" value="Передать файл">
        </form>
    </div>
</body>
</html>
