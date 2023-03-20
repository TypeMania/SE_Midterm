<?php
include_once('../../headers/GET.php');
include_once('../../models/Quote.php');
include_once('../../config/Database.php');

$db = (new Database())->connect();
$quote = new Quote($db);

$quote->id = isset($_GET['id']) ? $_GET['id'] : die();
$quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$quote->read_single();

if ($quote->read_single()) {
  echo json_encode(array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category
  ));
}
else echo json_encode(array('message'=>'No Quotes Found'));