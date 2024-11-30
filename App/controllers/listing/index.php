<?php
$config = require getPatch('config/dbconfig.php');
$db = new Database($config);

$listings = $db->query('SELECT * FROM listings')->fetchAll();
loadView('listing/listing', [
    'listings' => $listings
]);
