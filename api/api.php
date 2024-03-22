<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../env.php';

use MyApplication\Configure;


if( !Configure::enabled() ){ 
    http_response_code(503);
    echo "Desculpe, este serviço está temporariamente indisponível. Por favor, tente novamente mais tarde.";
    exit(); // ou die();
}

header('Content-Type: application/json');