<?php

namespace Client\Models\Services;

use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;
use PDO;
use PDOException;

/**
 * Checa no banco de dados se o valor desejado já existe ou não.
 */
class UniqueRule extends Model {
    /**
     * Faz a consulta no DB se o valor existe ou não.
     *
     * @param string $table Guarda a tabela desejda.
     * @param string $column Guarda a coluna desejada.
     * @param [type] $value Guarda o valor a ser verificado.
     * @return boolean
     */
    public function getRecord(string $table, string $column, $value):bool {
        try {
            // Query para a consulta. Retorna somente a quantidade de linhas encontradas.
            $query = "SELECT COUNT(id) as count FROM `{$table}` WHERE `{$column}` = :value";
            $stmt = $this->getConnection()->prepare($query);
    
            $stmt->bindValue(":value", $value, PDO::PARAM_STR);
    
            $stmt->execute();

            // Retorna TRUE se a quantidade de linhas é igual a zero.
            return $stmt->fetchColumn() === 0;
        } catch(PDOException $e) {
            // Gera um log de erro, pois não foi fossivel consultar o DB com as informações passadas.
            GenerateLog::generateLog("error", "Erro na consulta de valor único", ['query' => $query, 'table' => $table, 'column' => $column, 'value' => $value]);

            // Redirecinar para erro 500.
            ErrorPage::error500();
        }
    }
}