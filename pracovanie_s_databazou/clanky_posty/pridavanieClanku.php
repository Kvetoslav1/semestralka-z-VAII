<?php

/**
 * Classa pridáva nový článok pod kategóriu.
 * Ak prejde kontrolou zadaných parametrov tak pridá nový článok
 */

class pridavanieClanku
{
    /** Funkcia po kontrole údajov zistí id kategórie aby sa článok mohol pridať pod kategóriu, ktorú si vybral.
     * Ak prejde kontrolou tak sa článok pridá
     * @param $pripojenie - pripojenie do databázy
     * @param $nazovClanku - názov článku na vytvorenie
     * @param $email - email používateľa, ktorý vytvára článok
     * @param $idKategorie - id kategórie, aby článok bol správne priradený
     * @param $nadpis - nadpis článku
     */
    public function pridajClanok($pripojenie , $nazovClanku, $email, $idKategorie, $nadpis): void {
        if(strlen($nazovClanku) <= 40 && strlen($nadpis) <= 60) {
            $selectID = $pripojenie->prepare("select id_kategorie from kategorie where nazov_kategorie = ?");
            $selectID->bind_param('s', $_POST['kategoriaClanku']);
            if ($selectID->execute()) {
                $selectID->store_result();
                $selectID->bind_result($idKategorie);
                $selectID->fetch();
                $insertClanok = $pripojenie->prepare("insert into clanky (nazov_clanku, email_vytvarajuceho, id_kategorie, nadpis) values (?,?,?,?)");
                $insertClanok->bind_param('ssis', $nazovClanku, $email, $idKategorie, $nadpis);
                if ($insertClanok->execute()) {
                    header("Location: index.php");
                }
            }
        }
    }
}