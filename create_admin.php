<?php
include "classes/database.php";

$database = new DB\db();

$database->createAdmin();
$database->close();