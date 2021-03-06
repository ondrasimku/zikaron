<?php
require("classes/database.php");
require("classes/header.php");

use DB\db;
$database = new db();
$menu = new header($database);
?>

<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Zikaron</title>
    <link rel = "icon" href =
    "/images/logo_zikaron.png"
          type = "image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/cn1rqadcaivd2h5gfu98endasaenuof7n7zcl8ivx8fyc2gq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="scripts/menu.js" type="text/javascript"></script>
</head>
<body>
    <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk0gMCWObOWVl8YKzeSblZP4JFxUN3RoU&callback=initMap"></script>
<div class="container">

    <div class="header">
        <nav>
            <div class="menu-lines" id="menu-open">
                <div class="menu-line"></div>
                <div class="menu-line"></div>
                <div class="menu-line"></div>
            </div>
            <ul>
                    <?php
                    $menu->renderMenu();
                    ?>
            </ul>
        </nav>
    </div>

<div class="mobile-menu">
<div class="menu-content">
<a href="#" id="menu-close">&#10060;</a>
<?php
    $menu->renderMobileMenu();
?>
</div>
</div>

    <?php
/*
                <li><a href="#">Kameny zmizelých</a></li>
                <li><a href="#">Mapa</a></li>
                <li>
                    <div class="dropdown">
                        <a href="#contact">Památky</a>
                        <div class="dropdown-content">
                            <a href="#">Link 1</a>
                            <a href="#">Link 2</a>
                            <a href="#">Link 3</a>
                        </div>
                    </div>
                </li>
*/

?>