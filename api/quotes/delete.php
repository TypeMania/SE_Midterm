<?php
include_once('../../headers/DELETE.php');
include_once('../../models/Quote.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

$quote->id = $data->id;

if ($quote->delete()) {
  echo json_encode(array(
    'id'=>$quote->id
  ));
} else {
  echo json_encode(array('message'=>'No Quotes Found'));
}
