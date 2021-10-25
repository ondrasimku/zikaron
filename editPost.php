<?php
session_start();
require_once("classes/database.php");
require_once("classes/auth.php");
require_once("classes/postEditor.php");

$database = new DB\db();
$auth = new auth($database);

if(!$auth->isLogged())
{
    header('Location: admin-login.php');
}
$editor = new postEditor($database);

if($_GET)
{
    if(isset($_GET['deleteId']) && !empty($_GET['deleteId']))
    {
        if($editor->deleteItem($_GET['deleteId']))
        {
            header('Location: admin.php?message=Položka+smazána');
            die();
        }
        else
        {
            header('Location: admin.php?message=Chyba+při+mazání.+Pokud+problém+přetrvává,+kontaktujte+správce+webu.');
            die();
        }
    }
}

?>

<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/editPost.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <nav id="navbar">
            <ul id="navbar_ul">
                <li><a href="index.php">< Hlavní stránka ></a></li>
                <li><a href="admin-login.php?logout=1">< Odhlásit se ></a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <?php if(isset($message)) { echo($message); }  ?>
    </div>
</body>
</html>
