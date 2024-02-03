<?php

namespace Database;

use mysqli;

require_once __DIR__ . '/DatabaseConfig.php';

class DatabaseConnection
{
    private mysqli $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $this->conn = new mysqli(DatabaseConfig::$host, DatabaseConfig::$username, DatabaseConfig::$password, DatabaseConfig::$database);

        if ($this->conn->connect_error) {
            die(json_encode(['status' => 'error', 'message' => "Connection to database failed: " . $this->conn->connect_error]));
        }
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }

    public function closeConnection(): void
    {
        $this->conn->close();
    }
}