<?php

class Users extends connection
{
    // Для базы с логином
    public function createLogin($user)
    {
        try {
            $password = md5($_POST['password']);
            $statement = $this->connection->prepare("INSERT INTO users (login, password, email) VALUE (:login, :password, :email)");
            $statement->execute(array('login' => $_POST['login'], 'password' => $password, 'email' => $_POST['email']));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateLogin($user)
    {
        $password = md5($_POST['password']);
        $subject = 'Смена пароля.';
        $message = 'Вы изменили пароль на ' . $_POST['password'];
        $to = $_POST['email'];
        try {
            $statement = $this->connection->prepare('UPDATE users SET (password = :password) WHERE (login = :login, email = :email) LIMIT 1');
            $statement->execute(array('login' => $_POST['login'], 'email' => $_POST['email'], 'password' => $password));
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if (!empty($user)) {
                if ($_POST['login'] === $user['login']) {
                    if ($_POST['email'] === $user['email']) {
                        $meil = mail($to, $subject, $message);
                        if ($meil) {
                            header('location: ../../index.php');
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateAdmin($user)
    {
        try {
            $statement = $this->connection->prepare('UPDATE users SET login = :login, email = :email, role = :role WHERE id = :id');
            $statement->execute(array('login' => $_POST['login'], 'email' => $_POST['email'], 'role' => $_POST['role'], 'id' => $_POST['id']));
            $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteLogin($user)
    {
        try {
            $statement = $this->connection->prepare('DELETE FROM users WHERE login = :login AND email = :email');
            $statement->execute(array('login' => $_POST['login'], 'email' => $_POST['email']));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function check($login)
    {
        try {
            $password = md5($_POST['password']);
            $statement = $this->connection->prepare('SELECT * FROM users WHERE login = :login AND password = :password LIMIT 1');
            $statement->execute(array('login' => $_POST['login'], 'password' => $password));
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if (!empty($user)) {
                if ($_POST['login'] === $user['login']) {
                   if ($password === $user['password']) {
                       header('location: type/view/diplom.php');
                       $_SESSION['user'] = ["login" => $_POST['login']];
                       $_SESSION['id'] = ["id" => $user['id']];
                       if ($user['role'] > 0) {
                           $_SESSION['admin'] = ['login' => $_POST['login']];
                       }
                   }
                }
            } else {
                $_SESSION['message'] = 'Логин или пароль не правильный';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function list()
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM users');
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}