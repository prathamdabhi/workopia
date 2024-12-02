<?php

namespace App\controllers;

use Exception;
use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController
{
    protected $db;
    public function __construct()
    {
        $config = require getPatch('config/dbconfig.php');
        $this->db = new Database($config);
    }

    /**
     * show the login page
     * @return void
     */

    public function login()
    {
        loadView('users/login');
    }

    /**
     * show register page
     *
     * @return void
     */
    public function register()
    {
        loadView('users/register');
    }

    /**
     * function for storing data in database
     * 
     */

    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $confirm_password = $_POST['password_confirmation'];

        $error = [];

        if (!Validation::email($email)) {
            $error['email'] = "Invalid email address";
        }

        if (!Validation::string($name, 2, 50)) {
            $error['name'] = "Name must be between 2 and 50 characters";
        }

        if (!Validation::string($password, 8, 100)) {
            $error['password'] = "password must be at least 8 characters";
        }
        if (!Validation::match($password, $confirm_password)) {
            $error['confirm_password'] = "password does not match";
        }

        if (!empty($error)) {
            loadView('users/register', [
                "error" => $error,
                "user" => [
                    "name" => $name,
                    "email" => $email,
                    "city" => $city,
                    "state" => $state,
                    "password" => $password,
                    "confirm_password" => $confirm_password
                ]
            ]);
            exit;
        }

        //check if email already exists
        $params = [
            "email" => $email
        ];
        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if ($user) {
            $error['email'] = "Email already exists";
            loadView('users/register', [
                'error' => $error
            ]);
            exit;
        }

        // create a new user
        try {
            $params = [
                "name" => $name,
                "email" => $email,
                "city" => $city,
                "state" => $state,
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ];

            $this->db->query('INSERT INTO users(name, email, city, state, password) VALUES (:name, :email, :city,:state, :password)', $params);

            // Get new user ID
            $userId = $this->db->conn->lastInsertId();

            Session::set('user', [
                'id' => $userId,
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'state' => $state
            ]);
            redirect('/');
        } catch (Exception $e) {
            inspectAndDie($e->getMessage());
        }
    }

    /**
     * function for logout
     * @return void
     */

    public function logout()
    {
        Session::clearAll();
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', "", time() - 86400, $params['path'], $params['domain']);
        redirect('/');
    }

    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $error = [];

        if (!Validation::email($email)) {
            $error['email'] = "Invalid email address";
        }

        if (!Validation::string($password, 8, 100)) {
            $error['password'] = "password must be at least 8 characters";
        }

        //check for error
        if (!empty($error)) {
            loadView('users/login', [
                'error' => $error
            ]);
            exit;
        }

        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if (!$user) {
            $error['email'] = 'Incorrect credentials';
            loadView('users/login', [
                'error' => $error
            ]);
            exit;
        }

        // check if password is correct
        if (!password_verify($password, $user['password'])) {
            $error['password'] = 'Incorrect credentials';
            loadView('users/login', [
                'error' => $error
            ]);
            exit;
        }

        //set user Session

        Session::set('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'city' => $user['city'],
            'state' => $user['state']
        ]);
        redirect('/');
    }
}
