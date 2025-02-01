<?php

namespace Client\Models;

define("MODEL_NAME", "User.php");

use Client\Models\Services\DbConnection;
use PDO;
use PDOException;

class User extends DbConnection {
    public function all() {
        try {
            $query = "SELECT (id,username) FROM users";
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage());
        }
    }
}