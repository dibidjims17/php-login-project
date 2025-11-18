<?php
require 'config.php';

$collections = $db->listCollections();

echo "Collections in finals_system:<br>";
foreach ($collections as $col) {
    echo $col->getName() . "<br>";
}
