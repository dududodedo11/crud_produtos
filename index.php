<?php

use Client\Controllers\Services\PageController;
use Dotenv\Dotenv;

require "./vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

date_default_timezone_set($_ENV['APP_TIMEZONE']);

$url = new PageController();
$url->loadPage();



?>