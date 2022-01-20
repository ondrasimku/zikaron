<?php
require_once("classes/database.php");

class auth
{
    /**
     * @var DB\
     */
    private $db_object;
    /**
     * @var PDO
     */
    private $db_conn;
    public $lastError;

    public function __construct($db_object)
    {
        $this->db_object = $db_object;
        $this->db_conn = $this->db_object->getConnection();

    }

    public function __destruct()
    {
        $this->db_object->close();
        $this->db_conn = null;
    }

    public function checkApiCall()
    {
        return isset($_SESSION["is_logged"]);
    }

    public function isLogged()
    {
        if(!isset($_SESSION['is_logged']) || !isset($_SESSION['HTTP_USER_AGENT']))
            return false;

        if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']) || $_SESSION['is_logged'] != TRUE)
        {
            session_destroy();
            return false;
        }

        return true;
    }

    public function authenticate($username, $password)
    {
        $sql = "SELECT password from users where username=:name";

        try {
            $result = $this->db_conn->prepare($sql);
            $result->execute([':name' => $username]);
        } catch (PDOException $e) {
            $this->db_object->error('DB error: '.$e);
            $this->lastError = 'DB error: '.$e;
            return false;
        }

        $row = $result->fetch(PDO::FETCH_ASSOC);
        if(!is_array($row))
        {
            return false;
        }

        if(!password_verify($password, $row['password']))
        {
            return false;
        }

        session_regenerate_id();
        $_SESSION['is_logged'] = TRUE;
        $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
        return true;
    }
}