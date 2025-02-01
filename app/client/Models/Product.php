<?php

namespace Client\Models;

define("MODEL_NAME", "Product.php");

use Client\Models\Services\DbConnection;
use PDO;
use PDOException;

class Product extends DbConnection {
    public function all() {
        try {
            $query = "SELECT id, user_id, name, code, quantity FROM products";
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage());
        }
    }
}