<?php

/**
 * Classa registrácia vytvára nového používateľa do databázy.
 * Pri vytváraní používateľa sa skontroluje, či už taký používateľ neexistuje.
 * Ak používateľ neexistuje tak je následne pridaný do databázy.
 */

class registracia
{
    /**
     * @var string
     */
    private string $meno = "";
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
    private string $potvr_heslo = "";

    /** Funkcia nastavý premenú heslo na nové heslo
     * @param string $heslo - nastavenie hesla
     */
    public function setHeslo(string $heslo): void
    {
        $this->heslo = $heslo;
    }

    /** Funkcia vracia meno používateľa.
     * @return string
     */
    public function getMeno(): string
    {
        return $this->meno;
    }

    /** Funkcia vracia email
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /** Funkcia vracia heslo
     * @return string
     */
    public function getHeslo(): string
    {
        return $this->heslo;
    }

    /** Funkcia vracia, či sa heslá zhodujú
     * @return boolean
     */
    public function porovnanieHesiel() {
        return $this->heslo == $this->potvr_heslo;
    }

    /** Funkcia nastavuje parametre classy na vstupné parametre
     * @param $meno - meno používateľa
     * @param $email - email používateľa
     * @param $heslo - heslo používateľa
     * @param $potvrHeslo - potvrdzovacie heslo používateľa
     */
    public function setParametre($meno, $email, $heslo, $potvrHeslo) {
        $this->meno = $meno;
        $this->email = $email;
        $this->heslo = $heslo;
        $this->potvr_heslo = $potvrHeslo;
    }

    /** Funkcia zisťuje, či už neexistuje používateľ so zadanými parametrami. Následne vracia počet riadkov
     * @param $pripojenie - pripojenie na databázu
     * @param $kriterium - ktirérium, podľa ktorého sa vyberajú používatelia
     * @param $porovnanie - s čím sa má kritérium porovnať
     * @return mixed|null
     */
    public function zistiPouzivatelov($pripojenie, $kriterium, $porovnanie) {
        $select = $pripojenie->prepare("SELECT $kriterium FROM pouzivatel where $kriterium = ?");
        $select->bind_param('s', $porovnanie);
        if ($select->execute()) {
            $select->store_result();
            return $select->num_rows;
        }
        return null;
    }

    /** Funkcia pridá nového používateľa po tom, čo sa skontrolujú jeho údaje.
     * @param $pripojenie - pripojenie na databázu
     * @return bool
     */
    public function pridajPouzivatela($pripojenie): bool {
        if (strlen($this->meno) > 3 && strlen($this->meno) <= 20 && strlen($this->email) <= 30) {
            $insert = $pripojenie->prepare("INSERT INTO pouzivatel (meno,email,heslo,typ) VALUES (?,?,?,?)");
            $typ = "pouzivatel";
            $insert->bind_param('ssss', $this->meno, $this->email, $this->heslo, $typ);
            return $insert->execute();
        }
        return false;
    }

    /**
     * Funkcia vyčistí parametre classy
     */
    public function clear() {
        $this->meno = "";
        $this->email = "";
        $this->heslo = "";
        $this->potvr_heslo = "";
    }

}