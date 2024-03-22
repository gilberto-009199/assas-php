<?php 

require_once __DIR__ . '/vendor/autoload.php';


use jakobo\HOTP\HOTP;

// event based
$result = HOTP::generateByCounter( 239560869, 1 );

echo "Result:<br/>";
echo ($result->toHotp(5));