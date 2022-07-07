<?php

class File extends connection
{
    public function createFile($file, $uploadFile, $user)
    {
        try {
            $statement = $this->connection ->prepare('INSERT INTO files (name, directory, user_id) VALUE (:name, :directory, :id) SELECT id FROM users WHERE login = :login LIMIT 1');
            $statement->execute(array('name' => $_FILES['file']['name'], 'directory' => $uploadFile, 'login' => $_SESSION['user']['login']));
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

    public function getFile()
    {
        try {

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}