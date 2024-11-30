<?php

namespace App\controllers;

use Framework\Database;

class HomeController
{
    protected $db;
    public function __construct()
    {
        $config = require getPatch('config/dbconfig.php');
        $this->db = new Database($config);
    }
    public function fetchAll()
    {
        $listings = $this->db->query('SELECT * FROM listings LIMIT 4')->fetchAll();

        loadView('home', [
            'listings' => $listings
        ]);
    }
}
