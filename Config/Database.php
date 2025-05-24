<?php

namespace Config\Database;

use PDO;
use PDOException;

trait Connection {
    public function getConnection() {
        try { 
            $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $err) {
            error_log("Database Connection Error: " . $err->getMessage());
            throw new \Exception("Database connection failed. Please try again later.");
        }
    }
}