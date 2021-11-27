<?php

class reg
{
    private $meno;
    private $email;
    private $heslo;
    private $potvr_heslo;
    private $preslo;

    /**
     * @return bool
     */
    public function isPreslo()
    {
        return $this->preslo;
    }

    /**
     * @param bool $preslo
     */
    public function setPreslo($preslo)
    {
        $this->preslo = $preslo;
    }

    /**
     * @return mixed
     */
    public function getMeno()
    {
        return $this->meno;
    }

    /**
     * @param mixed $meno
     */
    public function setMeno($meno)
    {
        $this->meno = $meno;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getHeslo()
    {
        return $this->heslo;
    }

    /**
     * @param mixed $heslo
     */
    public function setHeslo($heslo)
    {
        $this->heslo = $heslo;
    }

    /**
     * @param mixed $potvr_heslo
     */
    public function setPotvrHeslo($potvr_heslo)
    {
        $this->potvr_heslo = $potvr_heslo;
    }

    public function porovnanieHesiel() {
        return $this->heslo == $this->potvr_heslo;
    }

    public function vycisti() {
        $this->meno = null;
        $this->email = null;
        $this->heslo = null;
        $this->potvr_heslo = null;
        $this->preslo = null;
        $this->pripojenie = null;
    }
}