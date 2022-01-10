<?php
include "pracovanie_s_databazou/pripojenieDatabaza.php";

$pripojenieDatabaza = new pripojenieDatabaza();

global $pripojenie;

$pripojenie = new mysqli($pripojenieDatabaza->getServName(), $pripojenieDatabaza->getUserName(), $pripojenieDatabaza->getPass(), $pripojenieDatabaza->getDatabase());
