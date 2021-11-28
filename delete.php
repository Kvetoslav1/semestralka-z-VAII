<?php
require "pripojenie.php";
session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: index.php");
}
$delete = $pripojenie->prepare("DELETE FROM pouzivatel where email = ?");
$delete->bind_param('s', $_SESSION['Email']);
$delete->execute();
session_destroy();
header("Location: index.php");
