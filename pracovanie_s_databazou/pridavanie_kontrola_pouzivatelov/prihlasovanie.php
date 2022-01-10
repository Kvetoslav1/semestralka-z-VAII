<?php

class prihlasovanie
{
    private string $email = "";
    private string $heslo = "";
    private string $hlaska = "";

    /**
     * @return string
     */
    public function getHlaska(): string
    {
        return $this->hlaska;
    }

    public function kontrolaPrihlasenie($pripojenie, $email, $password) {
        $select = $pripojenie->prepare("SELECT heslo, email FROM pouzivatel where email = ?");
        $select->bind_param('s', $email);
        if ($select->execute()) {
            $select->store_result();
            $select->bind_result($this->heslo, $this->email);
            $select->fetch();
            if ($select->num_rows == 1) {
                if (password_verify($password, $this->heslo)) {
                    return true;
                } else {
                    $this->hlaska = "Zadané heslo je nesprávne!";
                }
            } else {
                $this->hlaska = "Zadané meno alebo heslo je nesprávne!";
            }
        }
        return false;
    }
}