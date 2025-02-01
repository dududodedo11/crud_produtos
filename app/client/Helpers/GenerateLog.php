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

class GenerateLog {
    public static function generateLog(int|string $level, string $message, array|null $content):void {
        $log = new Logger('client');
        $nameFileLog = date("d-m-Y") . ".log";
        $filePath = "logs/" . $nameFileLog;

        $log->pushHandler(new StreamHandler($filePath, Level::Debug, true, 0666, true));

        $log->$level($message, $content);
    }
}