<?php

class pridavanieClanku
{
    public function pridajClanok($pripojenie , $nazovClanku, $email, $idKategorie, $nadpis): void {
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