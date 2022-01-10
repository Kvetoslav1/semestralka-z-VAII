<?php

class pripojenieDatabaza
{
    private string $servername = "semestralka_DB-server_1";
    private string $username = "root";
    private string $password = "password";
    private string $database = "Database";

    public function getServName () {
        return $this->servername;
    }

    public function getUserName () {
        return $this->username;
    }

    public function getPass () {
        return $this->password;
    }

    public function getDatabase () {
        return $this->database;
    }
}