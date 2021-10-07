<?php

namespace DB;

use PDOException;
use \PDO;

class db
{
    private $connection;
    private $show_errors = TRUE;

    public function __construct($dbhost='localhost',
                                $dbuser='root',
                                $dbpass='',
                                $dbname='',
                                $charset='utf8')
    {
        try {
            $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$charset", $dbuser, $dbpass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            $this->error('Failed to connect to database: ' . $e);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function error($error)
    {
        if($this->show_errors)
        {
            exit($error);
        }
    }

    /*public function createAdmin()
    {
        $hashed_password = password_hash('heslo123', PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(id_user,username,password) values (1,'admin','$hashed_password')";
        $this->connection->query($sql);
    }*/

    public function close()
    {
        $this->connection = null;
    }
}