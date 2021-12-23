<?php
session_start();
require_once("classes/database.php");
require_once("classes/auth.php");
require_once("classes/postEditor.php");
require("classes/header.php");

$database = new DB\db();
$auth = new auth($database);

if(!$auth->isLogged())
{
    header('Location: admin-login.php');
}
$postEditor = new postEditor($database);

if($_GET)
{
    if(isset($_GET['deleteId']) && !empty($_GET['deleteId']))
    {
        if($postEditor->deleteItem($_GET['deleteId']))
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
    else if(isset($_GET['id']) && !empty($_GET['id']))
    {
        $id_item = $_GET['id'];
    }
    else
    {
        die("404 Not found");
    }
}
else
{
    die("404 Not found");
}

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/editPost.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/cn1rqadcaivd2h5gfu98endasaenuof7n7zcl8ivx8fyc2gq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        div.header
        {
            height: 10vh;
        }
    </style>
</head>
<body>
<script>
    tinymce.init({
        selector: 'textarea',
        menubar: false,
        skin: 'oxide-dark',
        content_css: 'dark',
        entity_encoding : "raw",
        theme_advanced_background_colors : "FF00FF,FFFF00,000000",
        fontsize_formats:
            "0.5rem 0.7rem 0.9rem 1rem 1.1rem 1.2rem 1.3rem 1.4rem 1.5rem 1.6rem 1.7re 1.8rem 1.9rem 2rem 2.1rem 2.2rem 2.3rem 2.4rem 2.5rem 2.6rem 2.7rem 2.8rem 2.9rem 3rem",
        font_formats: "Play Fair=Playfair Display, serif; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; " +
            "Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; " +
            "Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; " +
            "Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; " +
            "Webdings=webdings; Wingdings=wingdings,zapf dingbats",
        content_style:  "body { font-family: Play Fair; font-size: 1.3rem; }",
        plugins: 'image autolink lists table code link',
        toolbar: 'image code aligncenter alignjustify alignleft alignright alignnone bold' +
            ' fontsizeselect fontselect h2 italic underline undo link unlink bulllist numlist',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',

        images_upload_url : 'upload.php',
        automatic_uploads : true,

    });

    $(document).ready(function(){

        $(".editForm").submit(function(event){
            event.preventDefault();
            if(!$("#header").val() || !$("#textArea").val()) {
                let form = $(".form-error");
                form.css("display", "block");
                form.html("Musíte vyplnit všechna pole!");
                return;
            }
            let myContent = tinymce.get("textArea").getContent();
            console.log(myContent);
            $.ajax({
                type: "POST",
                url: "process.php",
                data: $(this).serialize(),
                dataType: "json",
                encode: true,
                error: function(xhr, status, error) {
                    alert("Editace selhala. Pokud problém přetrvává kontaktuje správce webu.");
                },
                success: function(data) {
                    console.log("success");
                }
            }).done(function (data) {
                if(!data.success) {
                    let form = $(".form-error");
                    form.css("display", "block");
                    form.html(data.message);
                } else {
                    let form = $(".form-error");
                    form.css("display", "block");
                    form.css("color", "lime");
                    form.html(data.message);
                }
                console.log(data.success);
            });
            event.preventDefault();
        });
    });

</script>
    <div class="header">
        <nav id="navbar">
            <ul id="navbar_ul">
                <?php
                $menu = new header($database);
                $menu->renderMenu();
                ?>
            </ul>
        </nav>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <?php
            if(isset($id_item))
            {
                $post = $postEditor->getPostById($id_item);
                if($post === null)
                    die("Příspěvek nenalezen, pokud problém přetrvává, kontaktujte správce webu.");
            }
            ?>
            <form class="editForm" method="post">
                <div class="form-error">testicek</div>
                <input type="hidden" name="id_item" value="<?php echo($post->getId()); ?>">
                <input type="text" id="header" name="header" value="<?php echo $post->getHeader();?>">
                <textarea rows="50" name="text" id="textArea">
                    <?php echo $post->getText() ?>
                </textarea>
                <input type="submit" name="save" value="Submit" />
                <input type="reset" name="reset" value="Reset" />
            </form>
        </div>
    </div>
</body>
</html>
