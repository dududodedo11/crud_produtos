<?php

namespace Client\Models\Services;

use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;
use Client\Models\Services\DbConnection;

/**
 * Classe abstrata para guardar funções que serão usadas quase 100% das vezes por todas as models + a conexão com o banco de dados.
 * Todas as models herdam essa classe.
 */
abstract class Model extends DbConnection {
    /**
     * Gera um log para alguma consulta SQL feita por uma model específica.
     *
     * @param string $model Recebe de qual model foi o erro.
     * @param string $query Recebe a query em que ocorreu o erro.
     * @param string $pdoException Recebe a mensagem de erro.
     * @param array|string|null $optional Recebe uma string ou array de dados opcionais para serem salvos.
     * @return void
     */
    public function generateBasicLog(string $model, string $query, string $pdoException, array|string|null $optional):void {
        GenerateLog::generateLog("critical", "Erro na consulta SQL (Model: $model)", ["query" => $query, "PDOException" => $pdoException, "Outros dados" => $optional]);

        ErrorPage::error500();
    }
}