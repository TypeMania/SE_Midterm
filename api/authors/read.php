<?php
include_once('../../headers/GET.php');
include_once('../../models/Author.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$author = new Author($db);

$result = $author->read();

if ($result->rowCount() > 0) {
  $authors_arr = array();
  
  while ($row = $result->fetch(PDO::FETCH_ASSOC)){
    
    $author_obj = array(
      'id'     => $row['id'],
      'author' => $row['author']
    );
    
    array_push($authors_arr, $author_obj);
  }

  echo json_encode($authors_arr);
} else {
  echo json_encode(array('message'=>'author_id Not Found'));
}