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
    public function all():array
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
     * Retorna um array de produtos baseado na página requisitada e no limite definido.
     * É a função de paginação.
     *
     * @param integer $page É a página requisitada.
     * @param integer $limit É o limite de produtos por página.
     * @return array São retornados todos os produtos da página requisitada.
     */
    public function paginate(int $page, int $limit):array
    {
        // Tentativa de consulta com try-catch.
        try {
            $offset = ($page - 1) * $limit;

            // Fazendo consulta PDO.
            $query = "SELECT id, user_id, name, code, quantity, description 
            FROM products 
            WHERE user_id = :user_id 
            LIMIT :limit 
            OFFSET :offset";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(':user_id', $_SESSION['user_logged']['id'], PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

            $stmt->execute();

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
     * @param array $data São os dados do produto + o ID do usuário que criou o produto.
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
     * @param int $id É o ID do produto que será buscado.
     * @return array
     */
    public function getById(int $id):array
    {
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
     * Faz uma busca de produtos pelo nome.
     * Não retorna um em específico, mas um array de produtos que contenham o nome.
     *
     * @param string $name É o nome que será buscado.
     * @return array São retornados os produtos que possuam o nome.
     */
    public function searchByName(string $name):array {
        // Tentativa de consulta com try-catch.
        try {
            // Fazendo consulta PDO.
            $query = "SELECT id, user_id, name, code, quantity, description FROM products WHERE name LIKE :name AND user_id = :user_id";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue(':name', "%" . $name . "%", PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $_SESSION['user_logged']['id'], PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gera um log sério de erro na consulta SQL.
            $this->generateBasicLog(MODEL_NAME, $query, $e->getMessage(), null);
            return [];
        }
    }

    /**
     * Deleta um produto do banco de dados.
     *
     * @param int $id É o ID do produto que será deletado.
     * @return bool
     */
    public function delete(int $id):bool
    {
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

    /**
     * Atualiza um produto no banco de dados.
     *
     * @param array $data São os dados do produto que será atualizado.
     * @return bool
     */
    public function update(array $data): bool
    {
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
