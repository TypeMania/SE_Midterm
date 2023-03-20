<?php
include_once('../../headers/PUT.php');
include_once('../../config/Database.php');
include_once('../../models/Author.php');

$db = (new Database)->connect();
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->author)) exit(json_encode(array('message'=>'Missing Required Parameters')));
$author->id = $data->id;
$author->author = $data->author;

if ($author->update()) {
  echo json_encode(array(
    'id'=>$author->id,
    'author'=>$author->author
  ));
}