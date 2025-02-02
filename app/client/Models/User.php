<?php

namespace Client\Models;

// Define o nome da Model (usado no momento de salvar logs).
define("MODEL_NAME", "User.php");

use Client\Models\Services\Model;
use PDO;
use PDOException;

final class User extends Model {
        /**
     * Retorna todos os usuários do banco de dados.
     *
     * @return array
     */
    public function all():array {
        // Tentativa de consulta com try-catch.
        try {
            // Fazendo consulta PDO.
            $query = "SELECT id, username FROM users";
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
    
            // Retorna um array associativo de todos os usuários.
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
        }
    }
}