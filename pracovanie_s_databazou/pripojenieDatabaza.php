<?php

class pripojenieDatabaza
{
    private string $servername = "semestralka_DB-server_1";
    private string $username = "root";
    private string $password = "password";
    private string $database = "Database";

    public function getServName (): string
    {
        return $this->servername;
    }

    public function getUserName (): string {
        return $this->username;
    }

    public function getPass (): string {
        return $this->password;
    }

    public function getDatabase (): string {
        return $this->database;
    }
}