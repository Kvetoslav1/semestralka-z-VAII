<?php

class vyberanieDatabaza
{
    private int $pocetKategorii = 0;
    private int $idKategorie = 0;
    private int $pocetClankov = 0;
    private string $nazovKategorie = "";
    private string $nazovClanku = "";
    private string $nadpisClanku = "";

    /**
     * @return string
     */
    public function getNazovClanku(): string
    {
        return $this->nazovClanku;
    }

    /**
     * @return string
     */
    public function getNadpisClanku(): string
    {
        return $this->nadpisClanku;
    }

    /**
     * @return int
     */
    public function getPocetClankov(): int
    {
        return $this->pocetClankov;
    }


    /**
     * @return string
     */
    public function getNazovKategorie(): string
    {
        return $this->nazovKategorie;
    }

    /**
     * @return int
     */
    public function getIdKategorie(): int
    {
        return $this->idKategorie;
    }

    /**
     * @return int
     */
    public function getPocetKategorii(): int
    {
        return $this->pocetKategorii;
    }

    public function pocetKat($pripojenie): void {
        $selectPocetKategorii = $pripojenie->prepare("SELECT count(id_kategorie) from kategorie");
        if ($selectPocetKategorii->execute()) {
            $selectPocetKategorii->store_result();
            $selectPocetKategorii->bind_result($this->pocetKategorii);
            $selectPocetKategorii->fetch();
        }
    }

    public function vyberKategoriu($pripojenie, $cisloKategorie): void {
        $selectKategoria = $pripojenie->prepare("SELECT nazov_kategorie, id_kategorie from kategorie Limit ?,1");
        $selectKategoria->bind_param('i', $cisloKategorie);
        if ($selectKategoria->execute()) {
            $selectKategoria->store_result();
            $selectKategoria->bind_result($this->nazovKategorie, $this->idKategorie);
            $selectKategoria->fetch();
        }
    }

    public function pocetClankovKategorie($pripojenie): void {
        $selectPocetClankov = $pripojenie->prepare("SELECT count(nazov_clanku) from clanky where id_kategorie = ?");
        $selectPocetClankov->bind_param('i', $this->idKategorie);
        if ($selectPocetClankov->execute()) {
            $selectPocetClankov->store_result();
            $selectPocetClankov->bind_result($this->pocetClankov);
            $selectPocetClankov->fetch();
        }
    }

    public function vyberClanky($pripojenie, $cisloKategorie): void {
        $selectClanky = $pripojenie->prepare("select nazov_clanku, nadpis from clanky 
                        join kategorie k on clanky.id_kategorie = k.id_kategorie where k.id_kategorie = ? limit ?,1;");
        $selectClanky->bind_param('ii', $this->idKategorie, $cisloKategorie);
        if($selectClanky->execute()) {
            $selectClanky->store_result();
            $selectClanky->bind_result($this->nazovClanku, $this->nadpisClanku);
            $selectClanky->fetch();
        }
    }

    public function dajKategorie($pripojenie):void {
        $this->pocetKat($pripojenie);
        for($i = 0; $i < $this->pocetKategorii; $i++) {
            $selectKategoria = $pripojenie->prepare("SELECT nazov_kategorie from kategorie limit ?,1");
            $selectKategoria->bind_param('i', $i);
            if($selectKategoria->execute()) {
                $selectKategoria->store_result();
                $selectKategoria->bind_result($this->nazovKategorie);
                $selectKategoria->fetch();
                ?>
                <option><?php echo $this->nazovKategorie ?></option>
                <?php
            }
        }
    }
}