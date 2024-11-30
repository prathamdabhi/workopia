<?php

namespace Framework;

use PDO;
use PDOException;
use Exception;

class Database
{
    public $conn;
    /**
     * constructor for database class
     * @param array $config
     */
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception('Dataconnection failed: ' . $e->getMessage());
        }
    }

    /**
     * QUERY OF THE DATABASE
     * @param String $sql
     * @return  PDOstatement
     * @throws PDOException
     */

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            //Bind name params
            foreach ($params as $param => $value) {
                $stmt->bindvalue(":" . $param, $value);
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo "query failed to execute " . $e->getMessage();
        }
    }
}
