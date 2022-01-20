<?php
require_once("classes/database.php");
require_once("classes/auth.php");
use \DB\db;

class header
{
    /**
     * @var DB
     */
    private $db_object;
    /**
     * @var PDO
     */
    private $db_conn;

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

    public function renderMenu()
    {
        $sql = "select header, id_parent, id_item from text";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($items as $item)
        {
            if($this->hasParent($item))
                continue;
            $hasChild = $this->hasChild($item);
            if($hasChild)
            {
                $link = "#";
            }
            else
            {
                $link = "getPost.php?id=".$item['id_item'];
            }
            echo('<li>');
            if($hasChild)
            {
                echo('<div class="dropdown">');
                echo('<a href="'.$link.'">'.$item['header'].'</a>');
                echo('<div class="dropdown-content">');
                $this->renderChild($item);
                echo('</div>');
                echo('</div>');
            }
            else
            {
                echo('<a href="'.$link.'">'.$item['header'].'</a>');
            }
            echo('</li>');
        }
        $auth = new auth($this->db_object);
        if($auth->isLogged())
        {
            echo('<li><a href="admin.php">Admin Panel</a></li>');
        }

    }

    public function renderMobileMenu()
    {
        $sql = "select header, id_parent, id_item from text";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($items as $item)
        {
            if($this->hasParent($item))
                continue;
            $hasChild = $this->hasChild($item);
            if($hasChild)
            {
                $link = "#";
            }
            else
            {
                $link = "getPost.php?id=".$item['id_item'];
            }
            if($hasChild)
            {
                echo('<div class="dropdown">');
                echo('<a href="'.$link.'">'.$item['header'].' &rArr;</a>');
                $this->renderMobileChild($item);
                echo('</div>');
            }
            else
            {
                echo('<div class="dropdown">');
                echo('<a href="'.$link.'">'.$item['header'].'</a>');
                echo('</div>');
            }
        }
        $auth = new auth($this->db_object);
        if($auth->isLogged())
        {
            echo('<div class="dropdown">');
            echo('<a href="admin.php">Admin Panel</a>');
            echo('</div>');
        }
    }

    private function hasChild($item)
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

    private function hasParent($item)
    {
        $sql = "select id_parent from text where id_item=? and id_parent is not null";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$item['id_item']]);
        $stmt->execute();
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;
    }

    private function renderChild($item)
    {
        $sql = "select header, id_item from text where id_parent=?";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$item['id_item']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($items as $item)
        {
            echo('<a href="getPost.php?id='.$item['id_item'].'">'.$item['header'].'</a>');
        }
    }

    private function renderMobileChild($item)
    {
        $sql = "select header, id_item from text where id_parent=?";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->execute([$item['id_item']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($items as $item)
        {
            echo('<div class="dropdown-content"><a href="getPost.php?id='.$item['id_item'].'">'.$item['header'].'</a></div>');
        }
    }
};