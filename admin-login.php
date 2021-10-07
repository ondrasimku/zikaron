<?php
session_start();
require_once("classes/database.php");

if(isset($_SESSION['is_logged']))
{
    header('Location: admin.php');
}

if($_POST)
{
    if (!isset($_POST['username']) || !isset($_POST['password'])
        || empty($_POST['username']) || empty($_POST['password']))
    {
        $message = "Musíš vyplnit údaje...";
    }

    $database = new DB\db("localhost", "admin", "root", "zikaron_database");
    $auth = new auth($database);

    $username = $_POST['username'];
    $password = $_POST['password'];
    if(!$auth->authenticate($username, $password))
    {
        if(strpos($auth->lastError, "DB error:") !== false)
        {
            $message = "Login error, kontaktuj vývojáře.";
        }

        $message = "Špatné jméno nebo heslo.";
    }
    else
    {
        header('Location: admin.php');
    }

}

if($_GET)
{
    if(isset($_GET['logout']))
    {
        session_destroy();
        header('Location: admin-login.php');
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
    <div class="login-box">
        <h1>Admin Panel Login</h1>
        <form method="post" action="admin-login.php" class="login-form">
            <input type="text" placeholder="username" name="username">
            <input type="password" placeholder="password" name="password">
            <button>login</button>
            <p style="color: red;"><?php if(isset($message)) echo(htmlspecialchars($message));?></p>
        </form>
    </div>
</body>
</html>
