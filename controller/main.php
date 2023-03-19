<?php
require('.\config\Database.php');
$db = (new Database())->connect();
echo "End of main.php\n";