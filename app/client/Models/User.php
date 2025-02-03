<?php

namespace Client\Models;

// Define o nome da Model (usado no momento de salvar logs).
define("MODEL_NAME", "User.php");

use PDO;
use PDOException;
use Client\Models\Services\Model;

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
            $query = "SELECT (id, username) FROM users";
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
    
            // Retorna um array associativo de todos os usuários.
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
        }
        
    }

    public function create(array $dataUser):bool {
        $passwordWithHash = password_hash($dataUser['password'], PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $this->getConnection()->prepare($query);


            $stmt->bindValue(":username", $dataUser['username'], PDO::PARAM_STR);
            $stmt->bindValue(":password", $passwordWithHash, PDO::PARAM_STR);

            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), ['username' => $dataUser['username'], 'password' => $passwordWithHash]);
            return false;
        }

        return false;
    }
}