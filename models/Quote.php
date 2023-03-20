<?php
class Quote {
  private $conn;
  private $table = 'quotes';

  public $id;
  public $quote;
  public $author_id;
  public $category_id;

  public $author;
  public $category;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function read() {
    $query = "SELECT q.id, q.quote, c.category, a.author FROM {$this->table} as q
              JOIN categories as c ON q.category_id = c.id
              JOIN authors as a ON q.author_id = a.id ";
    $query .= isset($_GET['author_id']) || 
              isset($_GET['category_id']) || 
              isset($_GET['id']) ? "WHERE " : "";
    $query .= isset($_GET['id']) ? "q.id = :id " : "";
    $query .= isset($_GET['id']) && 
              (isset($_GET['author_id']) || isset($_GET['category_id'])) ? "AND " : "";
    $query .= isset($_GET['author_id']) ? "q.author_id = :author_id " : "";
    $query .= isset($_GET['author_id']) && isset($_GET['category_id']) ? "AND " : "";
    $query .= isset($_GET['category_id']) ? "q.category_id = :category_id " : "";
    $query .= "ORDER BY q.id ASC;";
    
    $stmt = $this->conn->prepare($query);

    if (isset($_GET['id'])) {
      $stmt->bindParam(':id', $_GET['id']);
    }
    
    if (isset($_GET['author_id'])) {
      $stmt->bindParam(':author_id', $_GET['author_id']);
    }
    
    if (isset($_GET['category_id'])) {
      $stmt->bindParam(':category_id', $_GET['category_id']);
    }
    
    try {
      $stmt->execute();
      return $stmt;
    } catch (PDOException $e) {
      exit("Error - Failure to read from database: {$e->getMessage()}");
      return false;
    }
  }

  public function read_single() {
    $query = "SELECT q.id, q.quote, c.category, a.author FROM {$this->table} as q
              JOIN categories as c ON q.category_id = c.id
              JOIN authors as a ON q.author_id = a.id
              WHERE q.id = :id LIMIT 1;";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $this->id);
    
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) return false;
    $this->id = $row['id'];
    $this->quote = $row['quote'];
    $this->author = $row['author'];
    $this->category = $row['category'];
    return true;
  }

  public function create() {
    $query = "INSERT INTO {$this->table}(id,quote,author_id,category_id) 
              VALUES (:id,:quote,:author_id,:category_id);";
    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);

    try {
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      
      $cstmt = $this->conn->prepare("SELECT * FROM categories WHERE id={$this->category_id}");
      $astmt = $this->conn->prepare("SELECT * FROM authors WHERE id={$this->author_id}");
      $cstmt->execute();
      $astmt->execute();
      if (!$astmt->fetch(PDO::FETCH_ASSOC)) echo json_encode(array('message'=>'author_id Not Found'));
      if (!$cstmt->fetch(PDO::FETCH_ASSOC)) echo json_encode(array('message'=>'category_id Not Found'));
      return false;
    }
  }

  function update() {
    $query = "UPDATE {$this->table} 
              SET quote=:quote, author_id=:author_id, category_id=:category_id
              WHERE id=:id";
    
    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);

    try {
      $stmt->execute();
      if (!is_array(json_decode(json_encode($stmt->fetch(PDO::FETCH_ASSOC))))) throw new PDOException("dangit");
      return true;
    } catch (PDOException $e) {
      $cstmt = $this->conn->prepare("SELECT * FROM categories WHERE id={$this->category_id}");
      $astmt = $this->conn->prepare("SELECT * FROM authors WHERE id={$this->author_id}");
      $qstmt = $this->conn->prepare("SELECT * FROM quotes WHERE id={$this->id}");
      $cstmt->execute();
      $astmt->execute();
      $qstmt->execute();
      if (!$astmt->fetch(PDO::FETCH_ASSOC)) echo json_encode(array('message'=>'author_id Not Found'));
      if (!$cstmt->fetch(PDO::FETCH_ASSOC)) echo json_encode(array('message'=>'category_id Not Found'));
      if (!$qstmt->fetch(PDO::FETCH_ASSOC)) echo json_encode(array('message'=>'No Quotes Found'));
      return false;
    }
  }

  function delete() {
    $query = "DELETE FROM {$this->table} WHERE id=:id;";
    $stmt = $this->conn->prepare($query);
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(':id', $this->id);
    if ($stmt->execute()) {
      if (!is_array(json_decode(json_encode($stmt->fetch(PDO::FETCH_ASSOC))))) return false;
      return true;
    } else {
      return false;
    }
  }
}