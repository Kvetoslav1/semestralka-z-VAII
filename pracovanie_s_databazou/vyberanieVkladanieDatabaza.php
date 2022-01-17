<?php

/**
 * Classa pracuje z databázou. Vyberá z nej potrebné parametre, ktoré sa využívajú na stránke.
 */

class vyberanieVkladanieDatabaza
{
    /**
     * @var int
     */
    private int $pocetKategorii = 0;
    /**
     * @var int
     */
    private int $idKategorie = 0;
    /**
     * @var int
     */
    private int $pocetClankov = 0;
    /**
     * @var string
     */
    private string $nazovKategorie = "";
    /**
     * @var string
     */
    private string $nazovClanku = "";
    /**
     * @var string
     */
    private string $nadpisClanku = "";
    /**
     * @var string
     */
    private string $nadpisPostu = "";
    /**
     * @var string
     */
    private string $emailVytvarajucehoPostu = "";



    /** Funkcia vracia nadpis postu
     * @return string
     */
    public function getNadpisPostu(): string
    {
        return $this->nadpisPostu;
    }

    /** Funkcia vracia email používateľa, ktorý vytvoril post
     * @return string
     */
    public function getEmailVytvarajucehoPostu(): string
    {
        return $this->emailVytvarajucehoPostu;
    }

    /** Funkcia vracia názov článku
     * @return string
     */
    public function getNazovClanku(): string
    {
        return $this->nazovClanku;
    }

    /** Funkcia vracia nadpis článku
     * @return string
     */
    public function getNadpisClanku(): string
    {
        return $this->nadpisClanku;
    }

    /** Funkcia vracia počet článkov
     * @return int
     */
    public function getPocetClankov(): int
    {
        return $this->pocetClankov;
    }


    /** Funkcia vracia názov kategórie
     * @return string
     */
    public function getNazovKategorie(): string
    {
        return $this->nazovKategorie;
    }

    /** Funkcia vracia id kategórie
     * @return int
     */
    public function getIdKategorie(): int
    {
        return $this->idKategorie;
    }

    /** Funkcia vracia počet kategórii
     * @return int
     */
    public function getPocetKategorii(): int
    {
        return $this->pocetKategorii;
    }

    /** Funkcia zistí počet kateórii z databázy, ktoré sa následne vykreslia
     * @param $pripojenie - pripojenie na databázu
     */
    public function pocetKat($pripojenie): void {
        $selectPocetKategorii = $pripojenie->prepare("SELECT count(id_kategorie) from kategorie");
        if ($selectPocetKategorii->execute()) {
            $selectPocetKategorii->store_result();
            $selectPocetKategorii->bind_result($this->pocetKategorii);
            $selectPocetKategorii->fetch();
        }
    }

    /** Funkcia vyberie kategóriu podla poradového čísla z databázy
     * @param $pripojenie - pripojenie na databázu
     * @param $cisloKategorie - číslo kategórie (poradie v databáze)
     */
    public function vyberKategoriu($pripojenie, $cisloKategorie): void {
        $selectKategoria = $pripojenie->prepare("SELECT nazov_kategorie, id_kategorie from kategorie Limit ?,1");
        $selectKategoria->bind_param('i', $cisloKategorie);
        if ($selectKategoria->execute()) {
            $selectKategoria->store_result();
            $selectKategoria->bind_result($this->nazovKategorie, $this->idKategorie);
            $selectKategoria->fetch();
        }
    }

    /** Funkcia zistí počet článkov kategórie z databázy
     * @param $pripojenie - pripojenie na databázu
     */
    public function pocetClankovKategorie($pripojenie): void {
        $selectPocetClankov = $pripojenie->prepare("SELECT count(nazov_clanku) from clanky where id_kategorie = ?");
        $selectPocetClankov->bind_param('i', $this->idKategorie);
        if ($selectPocetClankov->execute()) {
            $selectPocetClankov->store_result();
            $selectPocetClankov->bind_result($this->pocetClankov);
            $selectPocetClankov->fetch();
        }
    }

    /** Funkcia vyberie článok z databázy podla poradia
     * @param $pripojenie - pripojenie na databázu
     * @param $cisloKategorie - poradie článku v databáze
     */
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

    /** Funkcia vyberá kategórie z databázy pokiaľ nevyberie všetky kategórie
     * @param $pripojenie - pripojenie na databázu
     */
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

    /** Funkcia vyberá počet postov pod článkom z databázy
     * @param $pripojenie - pripojenie na databázu
     * @param $nazovClanku - názov článku podľa ktorého sa vyberie článok z databázy
     * @return int
     */
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

    /** Funkcia vyberá post z databázy podľa poradia
     * @param $pripojenie - pripojenie na databázu
     * @param $nazovClanku - názov článku podľa ktorého sa vyberá post z databázy
     * @param $poradie - poradie postu, ktorý sa vyberie z databázy
     */
    public function vypisPost($pripojenie, $nazovClanku, $poradie): void {
        $selectPost = $pripojenie->prepare("select nadpis_postu, email_pouzivatel from posty_v_clankoch where nazov_clanku = ? LIMIT ?,1");
        $selectPost->bind_param('si', $nazovClanku, $poradie);
        if($selectPost->execute()) {
            $selectPost->store_result();
            $selectPost->bind_result($this->nadpisPostu, $this->emailVytvarajucehoPostu);
            $selectPost->fetch();
        }
    }

    /** Funkcia vyberie text postu z databázy podľa vkladaného nadpisu
     * @param $pripojenie - pripojenie na databázu
     * @param $nazovPostu - názov postu podľa, ktorého sa vyberie text postu z databázy
     * @return string
     */
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

    /** Funkcia vyberá počet komentárov z databázy pod postom podľa nadpisu postu
     * @param $pripojenie - pripojenie na databázu
     * @param $nazovPostu - názov postu podľa, ktorého sa vyberie počet odpovedí na post z databázy
     * @return int
     */
    public function dajPocetKomentarovPostu ($pripojenie, $nazovPostu): int {
        $pocet = 0;
        $dajPocet = $pripojenie->prepare("select count(cas_odpovede) from odpovede_clanky where nadpis_postu = ?");
        $dajPocet->bind_param('s', $nazovPostu);
        if($dajPocet->execute()) {
            $dajPocet->store_result();
            $dajPocet->bind_result($pocet);
            $dajPocet->fetch();
        }
        return $pocet;
    }

    /** Funkcia vracia typ používateľa, resp. zisťuje, či je používateľ adminom
     * @param $pripojenie - pripojenie na databázu
     * @param $email - email používateľa, podľa ktorého sa vyberie typ používateľa
     * @return bool
     */
    public function isAdmin($pripojenie, $email): bool {
        $jeAdmin = "";
        $dajAdmina = $pripojenie->prepare("select typ from pouzivatel where email = ?");
        $dajAdmina->bind_param('s', $email);
        if($dajAdmina->execute()) {
            $dajAdmina->store_result();
            $dajAdmina->bind_result($jeAdmin);
            $dajAdmina->fetch();
            return $jeAdmin == "admin";
        }
        return false;
    }

    /** Funkcia pridáva novú kategóriu do databázy. Funkcia zisťuje, či už kategória neexistuje v databáze.
     * Ak neexistuje, tak vytvorý novú kategóriu
     * @param $pripojenie - pripojenie na databázu
     * @param $nazov - názov kategórie podľa ktorého sa pridá nová kategória do databázy
     * @return bool
     */
    public function pridajKategoriu($pripojenie, $nazov): bool {
        $vybranyNazov = "";
        if(strlen($nazov) >= 5 && strlen($nazov) <= 40) {
            $pridajKategoriu = $pripojenie->prepare("select nazov_kategorie from kategorie where nazov_kategorie = ?");
            $pridajKategoriu->bind_param('s', $nazov);
            $pridajKategoriu->execute();
            $pridajKategoriu->store_result();
            $pridajKategoriu->bind_result($vybranyNazov);
            $pridajKategoriu->fetch();
            if($pridajKategoriu->num_rows < 1) {
                $pridajKategoriu = $pripojenie->prepare("INSERT INTO kategorie (nazov_kategorie) VALUES (?)");
                $pridajKategoriu->bind_param('s', $nazov);
                if($pridajKategoriu->execute()) {
                    return true;
                }
            }
        }
        return false;
    }

    /** Funkcia pridáva novú odpoveď pod post  článku.
     * @param $pripojenie - pripojenie na databázu
     * @param $text - text odpovede v poste
     * @param $post - názov postu podľa, ktorého sa pridá odpoveď pod post
     * @param $emailOdpoved - email odpovedajúceho na post
     * @return bool
     */
    public function pridajOdpoved($pripojenie, $text, $post, $emailOdpoved): bool {
        $nazov_cl = "";
        $emailVytvarajuceho = "";
        $idKat = "";
        $emailPouzivatel = "";
        $select = $pripojenie->prepare("select  nazov_clanku, email_vytvarajuceho_clanku, id_kategorie, email_pouzivatel from posty_v_clankoch where nadpis_postu = ?");
        $select->bind_param('s', $post);
        if($select->execute()) {
            $select->store_result();
            $select->bind_result($nazov_cl, $emailVytvarajuceho, $idKat, $emailPouzivatel);
            $select->fetch();
            $select = $pripojenie->prepare("insert into odpovede_clanky (cas_odpovede, text_odpoved, nazov_clanku, email_vytvarajuceho_clanku, id_kategorie, email_pouzivatel, nadpis_postu, email)
            VALUES (CURRENT_TIME, ?, ?, ?, ?, ?, ?, ?)");
            $select->bind_param('sssisss', $text, $nazov_cl, $emailVytvarajuceho, $idKat, $emailPouzivatel, $post, $emailOdpoved);
            return $select->execute();
        }
        return false;
    }

    /** Funkcia zisťuje počet postov v článku. Tento počet sa následne vracia a vypisuje sa na hlavnej stránke
     * @param $pripojenie - pripojenie na databázu
     * @return int
     */
    public function dajPocetPostovClanku($pripojenie): int {
        $pocet = 0;
        $dajPocet = $pripojenie->prepare("select count(nadpis_postu) from posty_v_clankoch where nazov_clanku = ?");
        $dajPocet->bind_param('s', $this->nazovClanku);
        if($dajPocet->execute()) {
            $dajPocet->store_result();
            $dajPocet->bind_result($pocet);
            $dajPocet->fetch();
        }
        return $pocet;
    }

    /** Funkcia vracia počet odpovedí článku. Tento počet sa následne vypisuje na hlavnej stránke.
     * @param $pripojenie - pripojenie na databázu
     * @return int
     */
    public function dajPocetOdpovediClanku($pripojenie): int {
        $pocet = 0;
        $dajPocetOdpovedi = $pripojenie->prepare("select count(cas_odpovede) from odpovede_clanky where nazov_clanku = ?");
        $dajPocetOdpovedi->bind_param('s', $this->nazovClanku);
        if($dajPocetOdpovedi->execute()) {
            $dajPocetOdpovedi->store_result();
            $dajPocetOdpovedi->bind_result($pocet);
            $dajPocetOdpovedi->fetch();
        }
        return $pocet;
    }

    /** Funkcia vracia počet odpovedí postu, ktorý je vytvorený pod článkom. Tento počet sa vypisuje na stránke clanok
     * @param $pripojenie - pripojenie na databázu
     * @return int
     */
    public function dajPocetOdpovediPostu($pripojenie): int {
        $pocet = 0;
        $dajPocetOdpovedi = $pripojenie->prepare("select count(cas_odpovede) from odpovede_clanky where nadpis_postu = ?");
        $dajPocetOdpovedi->bind_param('s', $this->nadpisPostu);
        if($dajPocetOdpovedi->execute()) {
            $dajPocetOdpovedi->store_result();
            $dajPocetOdpovedi->bind_result($pocet);
            $dajPocetOdpovedi->fetch();
        }
        return $pocet;
    }
}