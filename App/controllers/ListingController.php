<?php

namespace App\controllers;

use Framework\Database;

class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require getPatch('config/dbconfig.php');
        $this->db = new Database($config);
    }

    public function fetchListings()
    {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();
        loadView('listing/listing', [
            'listings' => $listings
        ]);
    }
    public function createListing()
    {
        loadView('listing/create');
    }

    public function show($params2)
    {
        $id = $params2['id'] ?? '';
        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        // check listing still exists
        if (!$listing) {
            ErrorController::notFound("Listing not found");
            return;
        }
        loadView('listing/show', [
            'listing' => $listing
        ]);
    }
}
