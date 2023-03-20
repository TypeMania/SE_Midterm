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
        $query = "SELECT * FROM {$this->table} ";
        $query .= isset($_GET['id']) ? "WHERE id=:id;" : ";";
      
        $stmt = $this->conn->prepare($query);
        if (isset($_GET['id'])) {
          $stmt->bindParam(':id', $_GET['id']);
        }
      
        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            exit("Read failed. Could not execute statement: '{$query}'");
        }
    }

    public function read_single() {
      $query = "SELECT * FROM {$this->table} WHERE id=? LIMIT 1";
      
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!$row) return false;
      $this->id = $row['id'];
      $this->author = $row['author'];
      return true;
    }

    public function create() {
      $query = "INSERT INTO {$this->table}(id,author) VALUES (:id, :author)";
      
      $stmt = $this->conn->prepare($query);
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->author = htmlspecialchars(strip_tags($this->author));

      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':author', $this->author);

      if ($stmt->execute()) {
        return true;
      }
      return false;
    }

    public function update() {
      $query = "UPDATE {$this->table} SET author=:author WHERE id=:id";
      
      $stmt = $this->conn->prepare($query);
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->author = htmlspecialchars(strip_tags($this->author));

      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':author', $this->author);

      if ($stmt->execute()) {
        return true;
      }
      return false;
    }

    public function delete() {
      $query = "DELETE FROM {$this->table} WHERE id=:id";
      $stmt = $this->conn->prepare($query);
      $this->id = htmlspecialchars(strip_tags($this->id));
      $stmt->bindParam(':id', $this->id);
      if ($stmt->execute()) {
        return true;
      }
      return false;
    }
  
}