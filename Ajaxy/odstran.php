<?php
require "../pripojenie.php";

$post = $_REQUEST['nazov'];
if($post != "" && isset($pripojenie)) {
    $zmazanie = $pripojenie->prepare("delete from posty_v_clankoch where nadpis_postu = ?");
    $zmazanie->bind_param('s', $post);
    $zmazanie->execute();
}
