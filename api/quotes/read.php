<?php
include_once('../../headers/GET.php');
include_once('../../config/Database.php');
include_once('../../models/Quote.php');

$db = (new Database())->connect();
$quote = new Quote($db);

$result = $quote->read();

if ($result->rowCount() > 0) {
  $quote_arr = array();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $quote_obj = array(
      'id' => $row['id'],
      'quote' => $row['quote'],
      'author' => $row['author'],
      'category' => $row['category']
    );
    array_push($quote_arr, $quote_obj);
  }
  echo json_encode($quote_arr);
} else {
  echo json_encode(array('message'=>'No Quotes Found'));
}
