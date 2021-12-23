<?php
require_once("classes/postEditor.php");
require_once("classes/database.php");
require_once("classes/Post.php");

use DB\db;

if($_POST)
{
    if(isset($_POST["id_item"]) && isset($_POST["header"]) && isset($_POST["text"]) && !empty($_POST["id_item"]) && !empty($_POST["header"]) && !empty($_POST["text"]))
    {
        $database = new db();
        $postEditor = new postEditor($database);
        $post = $postEditor->getPostById($_POST["id_item"]);
        if($post === null)
        {
            echo json_encode(array("success"=>false, "message"=>"Chyba při editaci. Pokud problém přetrvává, kontaktujte správce webu."));
            die();
        }

        $post->setText($_POST["text"])
            ->setHeader($_POST["header"]);
        if(!$postEditor->savePost($post))
        {
            echo json_encode(array("success"=>false, "message"=>"Chyba při editaci. Pokud problém přetrvává, kontaktujte správce webu."));
            die();
        }

        echo json_encode(array("success"=>true, "message"=>"Příspěvek úspěšně upraven."));

    }
    else
    {
        echo json_encode(array("success"=>false, "message"=>"Chyba při editaci. Pokud problém přetrvává, kontaktujte správce webu."));
    }
}