<?php

namespace Client\Models\Services;

use PDO;
use PDOException;
use Client\Helpers\GenerateLog;

abstract class DbConnection {
    public object $connection;
    private string $dbHost;
    private string $dbPort;
    private string $dbName;
    private string $dbUser;
    private string $dbPassword;

    public function __construct() {
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbPort = $_ENV['DB_PORT'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->dbUser = $_ENV['DB_USER'];
        $this->dbPassword = $_ENV['DB_PASS'];
    }

    public function getConnection():object {
        try{
            $this->connection = new PDO("mysql:host=$this->dbHost;port=$this->dbPort;dbname=$this->dbName", $this->dbUser, $this->dbPassword);

            return $this->connection;
        } catch (PDOException $e) {
            GenerateLog::generateLog("emergency", "Erro na conexão do banco de dados: " . $e->getMessage(), ["dbHost" => $this->dbHost, "dbPort" => $this->dbPort, "dbName" => $this->dbName, "dbUser" => $this->dbUser, "dbPassword" => $this->dbPassword]);
        }
    }

    public function generateBasicLog(string $model, string $query, string $pdoException):void {
        GenerateLog::generateLog("critical", "Erro na consulta SQL (Model: $model)", ["query" => $query, "PDOException" => $pdoException]);
    }
}