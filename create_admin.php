<?php
include "classes/database.php";

$database = new db("localhost", "admin", "root", "zikaron_database");

$database->createAdmin();
$database->close();