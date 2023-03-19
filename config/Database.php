<?php
class Database {
    private $conn;
    private $host;
    private $user;
    private $pass;
    private $port;
    private $db;

    public function __construct() {
        $this->host = getenv('HOST');
        $this->user = getenv('USERNAME');
        $this->pass = getenv('PASSWORD');
        $this->port = getenv('PORT');
        $this->db   = getenv('DBNAME');
    }

    public function connect() {
        if ($this->conn) return $this->conn;

        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db};";

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            print("Failed to connect to database: {$e->getMessage()}\n");
        }
    }
}