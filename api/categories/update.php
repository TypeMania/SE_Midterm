<?php
include_once('../../headers/PUT.php');
include_once('../../config/Database.php');
include_once('../../models/Category.php');

$db = (new Database)->connect();
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->category)) exit(json_encode(array('message'=>'Missing Required Parameters')));
$category->id = $data->id;
$category->category = $data->category;

if ($category->update()) {
  echo json_encode(array(
    'id'=>$category->id,
    'category'=>$category->category
  ));
}