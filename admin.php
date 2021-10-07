<?php
session_start();
require_once("classes/database.php");
require "classes/auth.php";

$database = new DB\db("localhost", "admin", "root", "zikaron_database");
$auth = new auth($database);

if(!$auth->isLogged())
{
    header('Location: admin-login.php');
}

?>

<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/admin-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <a href="admin-login.php?logout=1">Odhlásit se</a>
</body>
</html>
