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
                                $dbname='zikaron',
                                $charset='utf8')
    {
        try {
            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
                PDO::MYSQL_ATTR_FOUND_ROWS => true,
            ];
            $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$charset", $dbuser, $dbpass, $options);
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