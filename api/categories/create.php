<?php
include_once('../../headers/POST.php');
include_once('../../config/Database.php');
include_once('../../models/Category.php');
include_once('../../functions/next_id.php');

$db = (new Database)->connect();
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = property_exists($data, 'id') ? $data->id : next_id('categories');
if (!isset($data->category)) exit(json_encode(array('message'=>'Missing Required Parameters')));
$category->category = $data->category;

if ($category->create()) {
  echo json_encode(array(
    'id'=>$category->id,
    'category'=>$category->category
  ));
} else {
  echo json_encode(array('message'=>'Missing Required Parameter'));
}