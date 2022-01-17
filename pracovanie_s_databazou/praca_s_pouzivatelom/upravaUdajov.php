<?php

/**
 * Classy upravuje údaje používateľa podľa toho ktoré zmenil.
 */

class upravaUdajov
{

    /** Funkcia zmení meno používateľa na nové meno, ktoré zadal. Najprv sa skontroluje, či už také meno neexistuje.
     * @param $pripojenie - pripojenie na databázu
     * @param $meno - meno používateľa
     * @param $email - email používateľa
     * @return bool
     */
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

    /** Funkcia mení heslo používateľa. Ak sa heslá rovnajú tak jedno z nich zacryptuje a nahradí ho za predošlé v databáze
     * @param $pripojenie - pripojenie na databázu
     * @param $email - email používateľa
     * @param $heslo - nové heslo používateľa
     * @param $potvrHeslo - potvrdzovacie heslo používateľa
     * @return bool
     */
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
}