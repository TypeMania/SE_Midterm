<?php
include_once('../../headers/DELETE.php');
include_once('../../models/Category.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;

if ($category->delete()) {
  echo json_encode(array(
    'id'=>$category->id
  ));
} else {
  echo json_encode(array('message'=>'No Quotes Found'));
}
