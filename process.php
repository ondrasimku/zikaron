<?php
session_start();
require_once("classes/postEditor.php");
require_once("classes/auth.php");
require_once("classes/database.php");
require_once("classes/Post.php");

use DB\db;
$database = new db();
$auth = new auth($database);

if(!$auth->checkApiCall())
{
    echo json_encode(array("success"=>false, "message"=>"Not authorized"));
}

if($_POST)
{
    $lat = null;
    $long = null;
    $link = null;
    if(isset($_POST["id_item"]) && isset($_POST["header"]) && isset($_POST["text"])
        && !empty($_POST["id_item"]) && !empty($_POST["header"]) && !empty($_POST["text"]))
    {
        if(isset($_POST["latitude"]) && isset($_POST["longitude"]) && isset($_POST["googleLink"]))
        {
            if(empty($_POST["googleLink"]) || empty($_POST["latitude"]) || empty($_POST["longitude"]))
            {
                echo json_encode(array("success"=>false, "message"=>"Chyba při načítání google linku"));
                die();
            }
            $lat = $_POST["latitude"];
            $long = $_POST["longitude"];
            $link = $_POST["googleLink"];
        }
        $database = new db();
        $postEditor = new postEditor($database);
        $post = $postEditor->getPostById($_POST["id_item"]);
        if($post === null)
        {
            echo json_encode(array("success"=>false, "message"=>"Chyba(post is null) při editaci. Pokud problém přetrvává, kontaktujte správce webu."));
            die();
        }
        if(!isset($lat) || !isset($long) || !isset($link))
        {
            $lat = NULL;
            $long = NULL;
            $link = NULL;
        }
        $post->setText($_POST["text"])
            ->setHeader($_POST["header"])
            ->setLatitude($lat)
            ->setLongitude($long)
            ->setLink($link);

        if(!$postEditor->savePost($post))
        {
            echo json_encode(array("success"=>false, "message"=>"Chyba(failed to save post) při editaci. Pokud problém přetrvává, kontaktujte správce webu."));
            die();
        }

        echo json_encode(array("success"=>true, "message"=>"Příspěvek úspěšně upraven."));

    }
    else
    {
        echo json_encode(array("success"=>false, "message"=>"Chyba při editaci. Pokud problém přetrvává, kontaktujte správce webu."));
    }
}