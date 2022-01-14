<?php

class pridavaniePostu
{

    public function dajEmailVytvarajuceho ($pripojenie, $nazovClanku): string {
        $emailVytvarajuci = "";
        $selectEmail = $pripojenie->prepare("select email_vytvarajuceho from clanky where nazov_clanku = ?");
        $selectEmail->bind_param('s', $nazovClanku);
        if($selectEmail->execute()) {
            $selectEmail->store_result();
            $selectEmail->bind_result( $emailVytvarajuci);
            $selectEmail->fetch();
        }
        return $emailVytvarajuci;
    }

    public function dajId($pripojenie, $nazovClanku): int {
        $idKategorie = 0;
        $selectId = $pripojenie->prepare("select id_kategorie from clanky where nazov_clanku = ?");
        $selectId->bind_param('s', $nazovClanku);
        if ($selectId->execute()) {
            $selectId->store_result();
            $selectId->bind_result($idKategorie);
            $selectId->fetch();
        }
        return $idKategorie;
    }

    public function pridajPost($pripojenie, $nazovClanku, $email, $text, $nadpis): bool {
        $idKat = $this->dajId($pripojenie, $nazovClanku);
        $emailVytvarajuci = $this->dajEmailVytvarajuceho($pripojenie, $nazovClanku);
        if($idKat > 0 && $emailVytvarajuci != "") {
            $insertPost = $pripojenie->prepare("INSERT INTO posty_v_clankoch 
    (nadpis_postu, nazov_clanku, email_vytvarajuceho_clanku, id_kategorie, email_pouzivatel, text) VALUES (?,?,?,?,?,?)");
            $insertPost->bind_param('sssiss',$nadpis, $nazovClanku, $emailVytvarajuci, $idKat, $email, $text);
            return $insertPost->execute();
        }
        return false;
    }

    public function updatePost($pripojenie, $nadpisStary, $nadpisNovy, $text): bool {
        $updatePostu = $pripojenie->prepare("update posty_v_clankoch set nadpis_postu = ?, text = ? where nadpis_postu = ?");
        $updatePostu->bind_param('sss', $nadpisNovy, $text, $nadpisStary);
        return $updatePostu->execute();
    }
}