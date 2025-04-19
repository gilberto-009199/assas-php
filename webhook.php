<?php 

require_once 'env.php';
require_once __DIR__ . '/api/api.php';

use MyApplication\Configure;

// Create Payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Verifica se o cabeçalho foi definido
   if (!isset($_SERVER['HTTP_ASAAS_ACCESS_TOKEN'])){
      http_response_code(404);
      exit(); // ou die();
   };

   // Acessa o valor do cabeçalho
   $accessToken = $_SERVER['HTTP_ASAAS_ACCESS_TOKEN'];

   // asaas-access-token
   if($_ENV['WEBHOOK'] != $accessToken) {
      http_response_code(500);
      exit(); // ou die();
   };

   // SEND SALE
   $data = Configure::readResponse();

   Configure::SALES()->hook( $data );

}
