<?php

class upravaUdajov
{

    public function zmenMeno ($pripojenie, $meno, $email): bool {
        $updateMeno = $pripojenie->prepare("SELECT meno FROM pouzivatel where meno = ?");
        $updateMeno->bind_param('s', $meno);
        if($updateMeno->execute()) {
            $updateMeno->store_result();
            if($updateMeno->num_rows == 0) {
                $updateMeno->prepare("UPDATE pouzivatel SET meno = ? where email = ?");
                $updateMeno->bind_param('ss', $meno, $email);
                if($updateMeno->execute()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function zmenHeslo ($pripojenie, $email, $heslo, $potvrHeslo): bool {
        if($heslo == $potvrHeslo) {
            $updateHeslo = $pripojenie->prepare("UPDATE pouzivatel set heslo = ? where email = ?");
            $heslo = password_hash($heslo, PASSWORD_BCRYPT);
            $updateHeslo->bind_param('ss', $heslo, $email);
            if($updateHeslo->execute()) {
                return true;
            }
        }
        return false;
    }

    public function odstranUcet ($pripojenie, $email): void {
        $delete = $pripojenie->prepare("DELETE FROM pouzivatel where email = ?");
        $delete->bind_param('s', $email);
        if($delete->execute()) {
            session_destroy();
            header("Location: index.php");
        }
    }
}