<?php

class vyberanieDatabaza
{
    private int $pocetKategorii = 0;
    private int $idKategorie = 0;
    private int $pocetClankov = 0;
    private string $nazovKategorie = "";
    private string $nazovClanku = "";
    private string $nadpisClanku = "";
    private string $nadpisPostu = "";
    private string $emailVytvarajucehoPostu = "";

    /**
     * @return string
     */
    public function getNadpisPostu(): string
    {
        return $this->nadpisPostu;
    }

    /**
     * @return string
     */
    public function getEmailVytvarajucehoPostu(): string
    {
        return $this->emailVytvarajucehoPostu;
    }

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

    public function dajPocetPostov($pripojenie, $nazovClanku): int {
        $pocetPostov = 0;
        $selectPocetPostov = $pripojenie->prepare("select count(nadpis_postu) from posty_v_clankoch where nazov_clanku = ?");
        $selectPocetPostov->bind_param('s', $nazovClanku);
        if($selectPocetPostov->execute()) {
            $selectPocetPostov->store_result();
            $selectPocetPostov->bind_result($pocetPostov);
            $selectPocetPostov->fetch();
        }
        return $pocetPostov;
    }

    public function vypisPost($pripojenie, $nazovClanku, $poradie): void {
        $selectPost = $pripojenie->prepare("select nadpis_postu,email_vytvarajuceho_clanku from posty_v_clankoch where nazov_clanku = ? LIMIT ?,1");
        $selectPost->bind_param('si', $nazovClanku, $poradie);
        if($selectPost->execute()) {
            $selectPost->store_result();
            $selectPost->bind_result($this->nadpisPostu, $this->emailVytvarajucehoPostu);
            $selectPost->fetch();
        }
    }

    public function dajTextPostu($pripojenie, $nazovPostu): string {
        $textPostu = "";
        $selectPost = $pripojenie->prepare("select text from posty_v_clankoch where nadpis_postu = ?");
        $selectPost->bind_param('s', $nazovPostu);
        if($selectPost->execute()) {
            $selectPost->store_result();
            $selectPost->bind_result($textPostu);
            $selectPost->fetch();
        }
        return $textPostu;
    }
}