<?php
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            exit("Read failed. Could not execute statement: '{$query}'");
        }
    }
}