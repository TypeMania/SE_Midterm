<?php
include_once('../../headers/DELETE.php');
include_once('../../models/Author.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->id = $data->id;

if ($author->delete()) {
  echo json_encode(array(
    'id'=>$author->id
  ));
} else {
  echo json_encode(array('message'=>'No Quotes Found'));
}
