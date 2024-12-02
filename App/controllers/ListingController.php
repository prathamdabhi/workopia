<?php

namespace App\controllers;

use Exception;
use Framework\Database;
use Framework\Validation;

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

    /**
     * store data in database
     * @param mixed $name
     *
     * @return void
     */
    public function store()
    {
        $allowedField = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];

        $newListingData = array_intersect_key($_POST, array_flip($allowedField));

        $newListingData['user_id'] = 1;
        $newListingData = array_map('sanitize', $newListingData);

        $requiredField = ['title', 'description', 'email', 'city', 'state', 'phone'];

        $error = [];

        foreach ($requiredField as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $error[$field] = ucfirst($field) . " is required";
            }
        }

        if (!empty($error)) {
            //Reload the view with error
            loadView('listing/create', [
                'error' => $error,
                'listing' => $newListingData
            ]);
        } else {
            try {
                $fields = [];
                foreach ($newListingData as $field => $value) {
                    $fields[] = $field;
                }
                $fields = implode(', ', $fields);
                $values = [];
                foreach ($newListingData as $field => $value) {
                    if ($value === "") {
                        $newListingData[$field] = null;
                    }
                    $values[] = ':' . $field;
                }

                $values = implode(', ', $values);
                $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
                $this->db->query($query, $newListingData);
                redirect('/listings');
            } catch (Exception $e) {
                inspectAndDie($e->getMessage());
            }
        }
    }

    /**
     * delete function
     */
    public function delete($params)
    {
        $id = $params['id'];

        $params = [
            'id' => $id
        ];

        $listing =  $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound("Listing not found");
            return;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $params);
        //set flash message
        $_SESSION['success_message'] = "Listing deleted successfully";
        redirect('/listings');
    }

    /**
     * Undocumented function
     *
     * @param [type] $params2
     * @return void
     */
    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        // check listing still exists
        if (!$listing) {
            ErrorController::notFound("Listing not found");
            return;
        }
        loadView('listing/edit', [
            'listing' => $listing
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        // check listing still exists
        if (!$listing) {
            ErrorController::notFound("Listing not found");
            return;
        }

        $allowedField = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];

        $updatedvalues = [];

        $updatedvalues = array_intersect_key($_POST, array_flip($allowedField));

        $updatedvalues = array_map('sanitize', $updatedvalues);

        $requiredField = ['title', 'description', 'email', 'city', 'state', 'phone'];

        $error = [];

        foreach ($requiredField as $field) {
            if (empty($updatedvalues[$field]) || !Validation::string($updatedvalues[$field])) {
                $error[$field] = ucfirst($field) . " is required";
            }
        }

        if (!empty($error)) {
            //Reload the view with error
            loadView('listing/edit', [
                'error' => $error,
                'listing' => $updatedvalues
            ]);
        } else {
            // submit to database
            try {
                $updatfields = [];
                foreach (array_keys($updatedvalues) as $field) {
                    $updatfields[] = "{$field} = :{$field}";
                }

                $updatfields = implode(', ', $updatfields);

                $updatequery = "UPDATE listings SET {$updatfields} WHERE id = :id";
                $updatedvalues['id'] = $id;
                $this->db->query($updatequery, $updatedvalues);
                $_SESSION['success_message'] = "Listing updated successfully";
                redirect('/listings/' . $id);
            } catch (Exception $e) {
                inspect($e->getMessage());
            }
        }
    }
}
