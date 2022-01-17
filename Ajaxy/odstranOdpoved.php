<?php
require "../pripojenie.php";

$casOdpovede = $_REQUEST['cas'];

if(isset($pripojenie)) {
    $odstran = $pripojenie->prepare("delete from odpovede_clanky where cas_odpovede = ?");
    $odstran->bind_param('s', $casOdpovede);
    $odstran->execute();
}
