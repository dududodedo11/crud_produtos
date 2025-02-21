<?php

namespace Client\Models;

// Define o nome da Model (usado no momento de salvar logs).
define("MODEL_NAME", "Product.php");


use PDO;
use PDOException;
use Client\Models\Services\Model;

final class Product extends Model {
    /**
     * Retorna todos os produtos do banco de dados.
     *
     * @return array
     */
    public function all():array {
        // Tentativa de consulta com try-catch.
        try {
            // Fazendo consulta PDO.
            $query = "SELECT id, user_id, name, code, quantity FROM products";
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
    
            // Retorna um array associativo de todos os produtos.
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
        }
    }

    public function create($data) {
        // Tentativa de consulta com try-catch.
        try {
            // Fazendo consulta PDO.
            $query = "INSERT INTO products (user_id, name, quantity, code, description) VALUES (:user_id, :name, :quantity, :code, :description)";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
            $stmt->bindValue(':code', $data['code'], PDO::PARAM_STR);
            $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);

            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), $data);
        }
    }
}