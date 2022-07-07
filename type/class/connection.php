<?php

class connection
{
    public $connection;
    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=localhost;dbname=users;charset=utf8" , "root", "root");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}