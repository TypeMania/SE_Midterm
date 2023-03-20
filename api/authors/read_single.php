<?php
include_once('../../headers/GET.php');
include_once('../../models/Author.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$author = new Author($db);

$author->id = isset($_GET['id']) ? $_GET['id'] : die();
$author->read_single();

if ($author->read_single()) {
  echo json_encode(array(
    'id' => $author->id,
    'author' => $author->author
  ));
}
else echo json_encode(array('message'=>'author_id Not Found'));