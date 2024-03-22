<?php

require_once __DIR__ . '/api.php';

use MyApplication\Configure;

// Create Payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // SEND SALE
    Configure::SALES()->createSale($_POST);

}
