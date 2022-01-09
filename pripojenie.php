<?php
$servername = "semestralka_DB-server_1";
$username = "root";
$password = "password";
$database = "Database";
global $pripojenie;
// Create connection
$pripojenie = new mysqli($servername, $username, $password, $database);
