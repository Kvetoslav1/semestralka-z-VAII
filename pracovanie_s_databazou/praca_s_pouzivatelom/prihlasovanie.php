<?php

/**
 * Classa kontroluje používateľom zadané parametre.
 * Pomocou funkcie kontrolaPrihlasenie sa vyberie z databázy používateľ podla zadaného emailu
 * Ak vytiahne jeden riadok tak skontroluje, či vložené heslo sa zhoduje s heslom v databáze.
 * Následne posiela nastavý hlášku podľa toho, či sa heslá zhodujú
 */

class prihlasovanie
{
    /**
     * @var string
     */
    private string $email = "";

    /**
     * @var string
     */
    private string $heslo = "";

    /**
     * @var string
     */
    private string $hlaska = "";


    /** Funkcia vracia chybnú hlášku
     * @return string
     */
    public function getHlaska(): string
    {
        return $this->hlaska;
    }

    /** Funkcia kontroluje, či zadané parametre používateľom sú validné a či sa heslá zhodujú.
     * @param $pripojenie - pripojenie na databázu
     * @param $email - email používateľa
     * @param $password - heslo používateľa
     * @return bool
     */
    public function kontrolaPrihlasenie($pripojenie, $email, $password) {
        if(strlen($this->email) <= 30) {
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
        }
        return false;
    }
}