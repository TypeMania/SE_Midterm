<?php
include_once('../../headers/GET.php');
include_once('../../models/Category.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($category->read_single()) {
  echo json_encode(array(
    'id' => $category->id,
    'category' => $category->category
  ));
}
else echo json_encode(array('message'=>'category_id Not Found'));