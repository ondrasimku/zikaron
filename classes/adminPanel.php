<?php
require_once("classes/database.php");
use \DB\db;
//https://stackoverflow.com/questions/41281752/how-to-get-longitude-and-latitude-from-google-map-url/41281834
class adminPanel
{
    /**
     * @var DB
     */
    protected $db_object;
    /**
     * @var PDO
     */
    protected $db_conn;

    public function __construct(db $database)
    {
        $this->db_object=$database;
        $this->db_conn= $database->getConnection();
    }

    public function __destruct()
    {
        $this->db_object->close();
        $this->db_conn = null;
    }

    public function renderItems()
    {
        $sql = "select header, id_item, id_parent from text";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($items as $item)
        {
            if($this->hasParent($item) || $item['id_parent'] == -1)
                continue;

            echo('<ul>');
            echo('<li>');
            echo($item['header']);
            if($this->hasChild($item))
            {
                echo('<a href="editPost.php?deleteId='.$item['id_item'].'" class="edit">Delete</a>');
                echo('<ul>');
                $this->renderChildItems($item);
                echo('</ul>');
            }
            else
            {
                if($item['id_item'] == 1)
                {
                    echo(' <a href="editPost.php?id='.$item['id_item'].'" class="edit">Edit</a>');
                }
                else
                {
                    echo(' <a href="editPost.php?id='.$item['id_item'].'" class="edit">Edit</a>'.
                        '<a href="editPost.php?deleteId='.$item['id_item'].'" class="edit">Delete</a>');
                }
            }
            echo('</li>');
            echo('</ul>');
        }

    }

    private function renderChildItems($item)
    {
        $sql = "select header, id_item from text where id_parent=?";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$item['id_item']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($items as $item)
        {
            echo('<li style="display: flex; justify-content: flex-start;">- '.$item['header'].' <a style="margin-left: auto;" href="editPost.php?id='.$item['id_item'].'" class="edit">Edit</a>'.
                '<a href="editPost.php?deleteId='.$item['id_item'].'" class="edit">Delete</a></li>');
        }
    }

    public function renderLoneItems()
    {
        $sql = "select header, id_item, id_parent from text where id_parent=-1";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo('<ul style="list-style: none;">');
        foreach($items as $item)
        {
            echo('<li style="display: flex; justify-content: flex-start">');
            echo('<input type="checkbox" name="idsArray[]" value="'.$item['id_item'].'">'.$item['header']);
            echo(' <a style="margin-left: auto;" href="editPost.php?id='.$item['id_item'].'" class="edit">Edit</a>'.
                    '<a href="editPost.php?deleteId='.$item['id_item'].'" class="edit">Delete</a>');
            echo('</li>');
        }
        echo('</ul>');
    }

    protected function hasChild($item)
    {
        $sql = "select id_item from text where id_parent=?";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$item['id_item']]);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;

    }

    protected function hasParent($item)
    {
        $sql = "select id_parent from text where id_item=? and id_parent is not null";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$item['id_item']]);
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;
    }

    public function addItem($headerName, $parentId)
    {
        if($parentId == 0)
        {
            $sql = "insert into text (header) values (?)";
            $stmt = $this->db_conn->prepare($sql);
            return $stmt->execute([$headerName]);
        }
        else
        {
            $sql = "insert into text (header, id_parent) values (?, ?)";
            $stmt = $this->db_conn->prepare($sql);
            return $stmt->execute([$headerName, $parentId]);
        }
    }

    public function getItemsArray()
    {
        $array = [];
        $sql = "select header, id_item, id_parent from text";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($items as $item)
        {
            if($this->hasParent($item) || $item['id_parent'] == -1)
                continue;

            if($this->hasChild($item))
            {
                $array[] = $item;
                $array[array_key_last($array)]['children'] = $this->getChildItems($item);
            }
            else
            {
                $array[] = $item;
            }
        }

        return $array;
    }

    private function getChildItems($item)
    {
        $array = [];
        $sql = "select header, id_item from text where id_parent=?";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$item['id_item']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($items as $item)
        {
            $array[] = $item;
        }
        return $array;
    }

    public function addBack($array, $parentId)
    {
        foreach($array as $id)
        {
            if($parentId == 0)
            {
                $sql = "update text set id_parent=NULL where id_item=?";
                $stmt = $this->db_conn->prepare($sql);
                $stmt->execute([$id]);
                if($stmt->rowCount() <= 0)
                    return false;
            }
            else
            {
                $sql = "update text set id_parent=? where id_item=?";
                $stmt = $this->db_conn->prepare($sql);
                $stmt->execute([$parentId, $id]);
                if($stmt->rowCount() <= 0)
                    return false;
            }

        }
        return true;
    }

}