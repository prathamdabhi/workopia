<?php
$config = require getPatch('config/dbconfig.php');
$db = new Database($config);

$id = $_GET['id'] ?? '';


$params = [
    'id' => $id
];
$listing = $db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();



loadView('listing/show', [
    'listing' => $listing
]);
