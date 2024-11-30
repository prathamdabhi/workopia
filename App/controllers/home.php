<?php
$config = require getPatch('config/dbconfig.php');
$db = new Database($config);

$listings = $db->query('SELECT * FROM listings LIMIT 4')->fetchAll();

loadView('home', [
    'listings' => $listings
]);
