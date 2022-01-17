<?php

require "../pripojenie.php";

session_start();

$email = $_GET['email'];

echo "<script>alert('Ahoj dement')</script>";
if(isset($pripojenie) && strlen($email) > 0) {
    $delete = $pripojenie->prepare("DELETE FROM pouzivatel where email = ?");
    $delete->bind_param('s', $email);

    if($delete->execute()) {
        session_destroy();
    }
}
