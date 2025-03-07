<?php

namespace Client\Helpers;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/*
Informações da dependência:

 *  - DEBUG (100): Informação de depuração.
 *  - INFO (200): Eventos interessantes. Por exemplo: um usuário realizou o login ou logs de SQL.
 *  - NOTICE (250): Eventos normais, mas significantes.
 *  - WARNING (300): Ocorrências excepcionais, mas que não são erros. Por exemplo: Uso de APIs descontinuadas, uso      inadequado de uma API. Em geral coisas que não estão erradas mas precisam de atenção.
 *  - ERROR (400): Erros de tempo de execução que não requerem ação imediata, mas que devem ser logados e monitorados.
 *  - CRITICAL (500): Condições criticas. Por exemplo: Um componente da aplicação não está disponível, uma exceção não esperada ocorreu.
 *  - ALERT (550): Uma ação imediata deve ser tomada. Exemplo: O sistema caiu, o banco de dados está indisponível , etc. Deve disparar um alerta para o responsável tomar providencia o mais rápido possível.
 *  - EMERGENCY (600): Emergência: O sistema está inutilizável.
*/

/**
 * Gera um log e guarda em um arquivo no "/logs".
 */
class GenerateLog {
    /**
     * Função para gerar um log.
     * Gera um log e guarda em um arquivo no "/logs".
     *
     * @param integer|string $level Nível de importância do log ("debug", "info", "notice", "warning", "error", "critical", "alert", "emergency").
     * @param string $message Título/Mensagem do log.
     * @param array|null $content Várias informações importantes para serem salvas junto ao log.
     * @return void
     */
    public static function generateLog(int|string $level, string $message, array|null $content):void {
        // Nome do log, sempre será client.
        $log = new Logger('client');

        if($content == null) {
            $content = [];
        }

        // Como será o título do log.
        $nameFileLog = date("d-m-Y") . ".log";

        // Onde será salvo o arquivo de log.
        $filePath = "logs/" . $nameFileLog;

        // Função da dependência para informações do log (onde será criada, a partir de que importância, permissões e opções, etc)
        $log->pushHandler(new StreamHandler($filePath, Level::Debug, true, 0666, true));

        // Cria e salva o log na pasta.
        $log->$level($message, $content);
    }
}