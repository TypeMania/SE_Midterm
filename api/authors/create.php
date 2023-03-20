<?php
include_once('../../headers/POST.php');
include_once('../../config/Database.php');
include_once('../../functions/next_id.php');
include_once('../../models/Author.php');

$db = (new Database)->connect();
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->id = property_exists($data, 'id') ? $data->id : next_id('authors');
if (!isset($data->author)) exit(json_encode(array('message'=>'Missing Required Parameters')));
$author->author = $data->author;

if ($author->create()) {
  echo json_encode(array(
    'id'=>$author->id,
    'author'=>$author->author
  ));
} else {
  echo json_encode(array('message'=>'Missing Required Parameter'));
}