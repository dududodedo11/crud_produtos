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

        // Se chegou até aqui, retorne um array vazio, pois deu erro.
        return [];
    }
}