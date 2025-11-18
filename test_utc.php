<?php
require __DIR__ . '/vendor/autoload.php';
use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

$dt = new UTCDateTime();
echo "UTCDateTime works! Timestamp: " . $dt->toDateTime()->format('Y-m-d H:i:s');
