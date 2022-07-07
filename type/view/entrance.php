<?php
session_start();

?>
<div class="container_fix">
    <form action="../../index.php" method="post">
        <input type="text" name="login" placeholder="Введите логин">
        <input type="password" name="password" placeholder="Введите пароль">
        <input type="submit" name="entrance_aut" value="Войти">
        <input type="submit" name="recovery" value="Забыл пароль">
    </form>
</div>
    <?php
    // предполается для вывода ошибки если войти не получатся
        if (isset($_SESSION['login_error'])) {
            echo '<div class="msg"' . $_SESSION['login_error'] . '</div>';
        }
        unset($_SESSION['login_error']);
    ?>
