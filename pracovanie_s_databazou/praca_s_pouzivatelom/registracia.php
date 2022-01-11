<?php

class registracia
{
    private string $meno = "";
    private string $email = "";
    private string $heslo = "";
    private string $potvr_heslo = "";

    /**
     * @param string $heslo
     */
    public function setHeslo(string $heslo): void
    {
        $this->heslo = $heslo;
    }

    /**
     * @return string
     */
    public function getMeno(): string
    {
        return $this->meno;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHeslo(): string
    {
        return $this->heslo;
    }

    /**
     * @return boolean
     */
    public function porovnanieHesiel() {
        return $this->heslo == $this->potvr_heslo;
    }

    public function setParametre($meno, $email, $heslo, $potvrHeslo) {
        $this->meno = $meno;
        $this->email = $email;
        $this->heslo = $heslo;
        $this->potvr_heslo = $potvrHeslo;
    }

    public function zistiPouzivatelov($pripojenie, $kriterium, $porovnanie) {
        $select = $pripojenie->prepare("SELECT $kriterium FROM pouzivatel where $kriterium = ?");
        $select->bind_param('s', $porovnanie);
        if ($select->execute()) {
            $select->store_result();
            return $select->num_rows;
        }
        return null;
    }

    public function pridajPouzivatela($pripojenie) {
        $insert = $pripojenie->prepare("INSERT INTO pouzivatel (meno,email,heslo,typ) VALUES (?,?,?,?)");
        $typ = "pouzivatel";
        $insert->bind_param('ssss',$this->meno,$this->email, $this->heslo, $typ);
        if($insert->execute()) {
            $message = "Účet bol vytvorený.";
        } else {
            $message = "Účet nebol vytvorený!.";
        }
        $this->clear();
        return $message;
    }

    public function clear() {
        $this->meno = "";
        $this->email = "";
        $this->heslo = "";
        $this->potvr_heslo = "";
    }

}