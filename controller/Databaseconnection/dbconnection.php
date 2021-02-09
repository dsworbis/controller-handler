<?php
  class DatabaseConnection {

    private $host;
    private $port;
    private $db;
    private $user;
    private $password;

    public function connect() {

        $this->host = '127.0.0.1';
        $this->port = '5432';
        $this->db = 'postgres';
        $this->user = 'postgres';
        $this->password = 'example';

        try {
            $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->db;user=$this->user;password=$this->password";
            $pdo = new PDO($dsn);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
        }
    }
  }
?>