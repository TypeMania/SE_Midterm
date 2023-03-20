<?php
include_once('../../headers/OPTION.php');

if     ($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['id'])) include_once('read_single.php');
elseif ($_SERVER['REQUEST_METHOD']==='GET') include_once('read.php');
elseif ($_SERVER['REQUEST_METHOD']==='POST') include_once('create.php');
elseif ($_SERVER['REQUEST_METHOD']==='PUT') include_once('update.php');
elseif ($_SERVER['REQUEST_METHOD']==='DELETE') include_once('delete.php');