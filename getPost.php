<?php
//session_start();
include "header.php";

use DB\db;

if($_GET)
{
    if($_GET["id"])
    {
        $id=$_GET["id"];

        $database = new db();
        $conn = $database->getConnection();
        $sql = "select * from text where id_item=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = $row;
        }
        if(!$posts)
        {
            $posts[0]['text'] = "No post";
        }
        $stmt=null;
    }
}

?>

<div class="content-wrapper">
    <div class="content">
        <h1>Kameny zmizelých</h1>
        <?php
            if(isset($posts))
            {
                echo($posts[0]['text']);
            }
        ?>
        <div id="map"></div>
    </div>
</div>

<?php
    include "footer.html";
?>

