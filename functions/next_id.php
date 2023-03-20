<?php

// Returns the greatest ID in specified table & adds one to it.
function next_id($table) {
  $query = "SELECT id FROM {$table} ORDER BY id DESC LIMIT 1";
  $stmt = (new Database())->connect()->prepare($query);
  try {
    $stmt->execute();
    return intval($stmt->fetch(PDO::FETCH_ASSOC)['id']) + 1;
  } catch (PDOException $e) {
    echo "Error in next_id function: {$e->getMessage()}";
    return -1;
  }
}