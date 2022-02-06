<?php

class db_handler
{
    private $serverId = "localhost";
    private $dbName = "squidbase";
    private $dbUser = "root";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->serverId, $this->dbUser, "", $this->dbName);

        if (!$this->conn)
        {
            die("Connection refused: " . mysqli_connect_error());
        }
    }

    public function getHandle()
    {
        return $this->conn;
    }

    public function closeHandle()
    {
        $this->conn->close();
    }
}