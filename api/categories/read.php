<?php
include_once('../../headers/GET.php');
include_once('../../models/Category.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$category = new Category($db);

$result = $category->read();

if ($result->rowCount() > 0) {
  $categories_arr = array();
  
  while ($row = $result->fetch(PDO::FETCH_ASSOC)){
    
    $category_obj = array(
      'id'     => $row['id'],
      'category' => $row['category']
    );
    
    array_push($categories_arr, $category_obj);
  }

  echo json_encode($categories_arr);
} else {
  echo json_encode(array('message'=>'category_id Not Found'));
}