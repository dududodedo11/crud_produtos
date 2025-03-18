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
    public function all():array|bool {
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

            return false;
        }
        
    }

    /**
     * Insere um novo usuário no banco de dados.
     *
     * @param array $dataUser Recebe os dados enviados pelo usuário.
     * @return boolean Retorna se foi cadastrado com sucesso.
     */
    public function create(array $dataUser):bool {
        // Cria uma variável para guardar a senha criptografada.
        $passwordWithHash = password_hash($dataUser['password'], PASSWORD_ARGON2ID);

        // Tentativa de consulta com try-catch.
        try {
            // Criando a query e preparando ela.
            $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $this->getConnection()->prepare($query);

            // Nomeando os valores da query.
            $stmt->bindValue(":username", $dataUser['username'], PDO::PARAM_STR);
            $stmt->bindValue(":password", $passwordWithHash, PDO::PARAM_STR);

            // Executando a query.
            $stmt->execute();
            
            // Se chegou até aqui, quer dizer que funcionou, retorne true.
            return true;
        } catch (PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), ['username' => $dataUser['username'], 'password' => $passwordWithHash]);

            return false;
        }
    }

    public function getUser(string $username):array|bool {
        try {
            $query = "SELECT id, username, password FROM users WHERE BINARY username = :username";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(":username", $username, PDO::PARAM_STR);

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user;
        } catch(PDOException $e) {
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), ['username' => $username]);

            return false;
        }
    }
}