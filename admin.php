<?php
session_start();
require_once("classes/database.php");
require_once("classes/auth.php");
require_once("classes/adminPanel.php");

$database = new DB\db();
$auth = new auth($database);

if(!$auth->isLogged())
{
    header('Location: admin-login.php');
}

$admin = new adminPanel($database);

if($_GET)
{
    if(isset($_GET['message']) && !empty($_GET['message']))
    {
        if(str_contains($_GET['message'], "smazána"))
        {
            $message = '<span style="margin-left: 2rem; color: lime;">'.htmlspecialchars($_GET['message']).'</span>';
        }
        else
        {
            $message = '<span style="margin-left: 2rem; color: red;">'.htmlspecialchars($_GET['message']).'</span>';
        }

    }
}

if($_POST)
{
    if(isset($_POST['add']))
    {
        if(isset($_POST['headerName']) && !empty($_POST['headerName']) && isset($_POST['parentId']))
        {
            if($admin->addItem($_POST['headerName'], $_POST['parentId']))
            {
                $message = '<span style="margin-left: 2rem; color: lime;">Položka přidána</span>';
            }
            else
            {
                $message = '<span style="margin-left: 2rem; color: red;">Database ERROR kontaktujte správce webu!</span>';
            }
        }
        else
        {
            $message = '<span style="margin-left: 2rem; color: red;">Musíte zadat název položky!</span>';
        }
    }
    else if(isset($_POST['addBack']))
    {

    }
    else
    {
        $message = '<span style="margin-left: 2rem; color: red;">Error, pokud problém přetrvává, kontaktuje správce webu.</span>';
    }
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
    <header>
        <nav id="navbar">
            <ul id="navbar_ul">
                <li><a href="index.php">< Hlavní stránka ></a></li>
                <li><a href="admin-login.php?logout=1">< Odhlásit se ></a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <div class="flex-item">
            <?php if(isset($message)) { echo($message); } ?>
            <h2>Položky menu</h2>
            <hr>
            <div class="menu-items">
                <?php $admin->renderItems(); ?>
            </div>
            <form action="admin.php" method="post" class="addPost">
                <select name="parentId">
                    <option value="0">Hlavní položka</option>
                    <?php $array = $admin->getItemsArray();

                    foreach($array as $item)
                    {
                        echo('<option value="'.$item['id_item'].'">');
                        echo($item['header']);
                        echo('</option>');
                    }

                    ?>
                </select><br>
                <input type="text" name="headerName">
                <button type="submit" name="add">Přidat položku</button>
            </form>
            <h2>Nezařazené položky</h2>
            <hr>
            <div class="menu-items">
                <?php $admin->renderLoneItems(); ?>
            </div>
            <form action="admin.php" method="post" class="addPost">
                <select name="parentId">
                    <option value="0">Hlavní položka</option>
                    <?php $array = $admin->getItemsArray();

                    foreach($array as $item)
                    {
                        echo('<option value="'.$item['id_item'].'">');
                        echo($item['header']);
                        echo('</option>');
                    }

                    ?>
                </select><br>
                <button type="submit" name="addBack">Přidat položku</button>
            </form>
        </div>
        <div class="flex-item">
            <ul class="info">
                <li>Přidaná položka nemá potomka a slouží tedy jako odkaz.</li>
                <li>Položka s aspoň jedním potomkem slouží jako rozklikávací část menu.</li>
                <li>Smazaný potomek nemá vliv na zbytek menu.</li>
                <li>Smazaný rozklikávací prvek přesune všechny své potomky do sekce "nezařazeno".</li>
                <li>Nezařazené položky lze přiřadit zpět do menu dle volby.</li>
            </ul>
        </div>
    </div>
</body>
</html>
