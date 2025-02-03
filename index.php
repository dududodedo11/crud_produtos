<?php

use Client\Controllers\Services\PageController;
use Dotenv\Dotenv;

session_start();

// Iniciando o composer.
require "./vendor/autoload.php";

// Iniciando a deppendência para o uso do .env.
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Definindo o fuso-horário da aplicação inteira.
date_default_timezone_set($_ENV['APP_TIMEZONE']);

// Chamado a classe que irá limpar a URL e iniciar os fluxos da aplicação.
$url = new PageController();
$url->loadPage();
?>