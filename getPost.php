<?php
session_start();
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
        if(empty($posts))
        {
            die("<h1>Příspěvek nenalezen, pokud problém přetrvává, kontaktujte správce webu.</h1>");
        }
        $stmt=null;
    }
}

?>
<div class="content-wrapper">
    <div class="content">
        <?php
            echo("<h1>");
            echo($posts[0]['header']);
            echo("</h1>");
            echo($posts[0]['text']);
            if($posts[0]['latitude'] != null)
            {
                $latitude = $posts[0]['latitude'];
                $longitude = $posts[0]['longitude'];
                echo('<script>');
                echo('var latitude = ');
                echo($latitude.';');
                echo('var longitude = ');
                echo($longitude.';');
                echo('</script>');
                echo('<script type="text/javascript" src="scripts/google_maps.js"></script>');
                echo('<div class="navigate-link-div">');
                echo('<a class="nagivate-link" target="_blank" href="https://www.google.com/maps/dir/?api=1&travelmode=driving&layer=traffic&destination='.$latitude.','.$longitude.'">navigovat</a>');
                echo('</div>');
                echo('<div id="map"></div>');
            }
        ?>

    </div>
</div>

<?php
    include "footer.html";
?>

