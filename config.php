<?php
require 'vendor/autoload.php'; // Composer autoload

use MongoDB\Client;

$mongoClient = new Client("mongodb://localhost:27017");
$db = $mongoClient->selectDatabase("finals_system"); // Change if you want a different name
?>
