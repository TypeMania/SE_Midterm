<?php
include_once('../../headers/POST.php');
include_once('../../config/Database.php')
include_once('../../models/Author.php');
$db = (new Database)->connect();
$author = new Author($db);

