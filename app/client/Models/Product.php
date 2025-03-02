<?php

namespace Client\Models;

// Define o nome da Model (usado no momento de salvar logs).
define("MODEL_NAME", "Product.php");


use PDO;
use PDOException;
use Client\Models\Services\Model;

final class Product extends Model
{
    /**
     * Retorna todos os produtos do banco de dados.
     *
     * @return array
     */
    public function all(): array
    {
        // Tentativa de consulta com try-catch.
        try {
            // Fazendo consulta PDO.
            $query = "SELECT id, user_id, name, code, quantity FROM products WHERE user_id = :user_id";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(':user_id', $_SESSION['user_logged']['id'], PDO::PARAM_INT);

            $stmt->execute();

            // Retorna um array associativo de todos os produtos.
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
            return [];
        }
    }

    /**
     * Cria um novo produto no banco de dados.
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data):bool
    {
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
        } catch (PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), $data);
            return false;
        }
    }

    /**
     * Retorna um produto pelo seu ID.
     *
     * @param int $id
     * @return array
     */
    public function getById(int $id):array {
        // Tentativa de consulta com try-catch.
        try {
            // Fazendo consulta PDO.
            $query = "SELECT id, user_id, name, code, quantity, description FROM products WHERE id = :id AND user_id = :user_id LIMIT 1";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $_SESSION['user_logged']['id'], PDO::PARAM_INT);

            $stmt->execute();

            $response = $stmt->fetch(PDO::FETCH_ASSOC);

            return $response;
        } catch (PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
            return [];
        }
    }

    /**
     * Deleta um produto do banco de dados.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool {
        try {
            // Fazendo consulta PDO.
            $query = "DELETE FROM products WHERE id = :id AND user_id = :user_id";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $_SESSION['user_logged']['id'], PDO::PARAM_INT);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
            return false;
        }
    }

    public function update(array $data):bool {
        try {
            // Fazendo consulta PDO.
            $query = "UPDATE products SET name = :name, quantity = :quantity, code = :code, description = :description WHERE id = :id AND user_id = :user_id";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $_SESSION['user_logged']['id'], PDO::PARAM_INT);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
            $stmt->bindValue(':code', $data['code'], PDO::PARAM_STR);
            $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
            return false;
        }
    }
}
