<?php

/**
 * Classa tvorí pripojenie do databázy
 */

class pripojenieDatabaza
{
    /**
     * @var string
     */
    private string $servername = "semestralka_DB-server_1";
    /**
     * @var string
     */
    private string $username = "root";
    /**
     * @var string
     */
    private string $password = "password";
    /**
     * @var string
     */
    private string $database = "Database";

    /** Funkcia vracia meno serveru
     * @return string
     */
    public function getServName (): string
    {
        return $this->servername;
    }

    /** Funkcia vracia prihlasovacie meno na databázu
     * @return string
     */
    public function getUserName (): string {
        return $this->username;
    }

    /** Funkcia vracia prihlasovacie heslo do databázy
     * @return string
     */
    public function getPass (): string {
        return $this->password;
    }

    /** Funkcia vracia názov databázy
     * @return string
     */
    public function getDatabase (): string {
        return $this->database;
    }
}