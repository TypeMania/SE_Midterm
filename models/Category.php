<?php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

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
      if (!$row) return false;
      $this->id = $row['id'];
      $this->category = $row['category'];
      return true;
    }

    public function create() {
      $query = "INSERT INTO {$this->table}(id,category) VALUES (:id, :category)";
      
      $stmt = $this->conn->prepare($query);
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->category = htmlspecialchars(strip_tags($this->category));

      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':category', $this->category);

      if ($stmt->execute()) {
        return true;
      }
      return false;
    }

    public function update() {
      $query = "UPDATE {$this->table} SET category=:category WHERE id=:id";
      
      $stmt = $this->conn->prepare($query);
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->category = htmlspecialchars(strip_tags($this->category));

      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':category', $this->category);

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