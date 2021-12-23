<?php
require_once("classes/database.php");
require_once("classes/adminPanel.php");
require_once("classes/Post.php");
use \DB\db;
class postEditor extends adminPanel
{
    public function __construct(\DB\db $database)
    {
        parent::__construct($database);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function getPostById(int $id) : ?Post
    {
        $sql = "select * from text where id_item=?";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$result)
            return null;
        else
            return new Post($result["header"], $result["text"], $result["id_item"], $result["id_parent"]);

    }

    public function savePost(Post & $post) : bool
    {
        $sql = "update text set text=?, header=? where id_item=?";
        $stmt = $this->db_conn->prepare($sql);
        return $stmt->execute([$post->getText(), $post->getHeader(), $post->getId()]);
    }

    public function deleteItem($id)
    {
        $sql = "select id_item from text where id_item=?";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$id]);
        if($stmt->rowCount() <= 0) // if id doesnt exist in database
        {
            return false;
        }

        $sql = "select id_item from text where id_item=? and id_parent is null";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$id]);
        if($stmt->rowCount() > 0) // were deleting parent element
        {
            $sql = "select id_item from text where id_parent=?";
            $stmt = $this->db_conn->prepare($sql);
            $stmt->execute([$id]);
            if($stmt->rowCount() == 0)
            {
                $sql = "delete from text where id_item=?";
                $stmt = $this->db_conn->prepare($sql);
                return $stmt->execute([$id]);
            }

            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($items as $item)
            {
                $sql = "update text set id_parent=-1 where id_item=?";
                $stmt = $this->db_conn->prepare($sql);
                if($stmt->execute([$item['id_item']]) == false || $stmt->rowCount() <= 0)
                    return false;
            }

            $sql = "delete from text where id_item=?";
            $stmt = $this->db_conn->prepare($sql);
            return $stmt->execute([$id]);

        }

        // if child
        $sql = "delete from text where id_item=?";
        $stmt = $this->db_conn->prepare($sql);
        return $stmt->execute([$id]);
    }


}