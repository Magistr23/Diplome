<?php

class File extends connection
{
    public function createFile($file, $uploadFile, $user)
    {
        try {
            $statement = $this->connection ->prepare('SELECT id FROM users WHERE login = :login');
            $statement ->execute(array('login' => $_SESSION['user']['login']));
            $user = $statement->fetch();
            $statement = $this->connection ->prepare('INSERT INTO files (name, directory, user_id) VALUE (:name, :directory, :user_id)');
            $statement->execute(array('name' => $_FILES['file']['name'], 'directory' => $uploadFile, 'user_id' => $user['id']));
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function listFile()
    {
        try {
            $statement = $this->connection ->prepare('SELECT files.*, users.* FROM users LEFT JOIN files ON users.id=files.user_id');
            $statement->execute();
            return $statement->fetchAll();
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function detFile($files)
    {
        try {
            $statement = $this->connection ->prepare('DELETE FROM files WHERE name = :delete_file');
            $statement->execute(array('delete_file' => $_POST['login']));
            unlink('../user/' . $_SESSION['user']['login'] . '/' . $_POST['login']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}