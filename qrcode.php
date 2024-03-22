<?php

require_once __DIR__ . '/vendor/autoload.php';

use chillerlan\QRCode\{QRCode, QROptions};


$options = new QROptions;



$options->version      = 4;
$options->scale        = 3;
$options->outputBase64 = true;
$options->imageTransparent    = true;

$data = 'otpauth://totp/test?secret=B3JX4VCVJDVNXNZ5&issuer=chillerlan.net';
$data = "iKXUtrE9MbV4Ooa1cnY0rm2aRhBzJd9okhAmQA2wLhU349eEBmG8hnHwyjgbkNCnfMwxCufkpVY7Rd1cRMsYhQCSzWGpi5H/HWIOLv9gMCMOM4Pur4fQM512dBok2UIW4MDgl3nETL64CB89yUbC7/KWlxKQ8ShZ1amea/8MykbWPyim/zp77CcbKyznyCUNyoLnVdVnMtS5iH1e9kmNQsuiQ6EhHod2Jb56YPo66D78D2Awdf7zDkTpvKDOroX1Q5+iTGaZbJ8CA8EmWfXPQom/N6BqMK4hD6k9srwsGwjkjjBCUKb0xc+p0Wi628hbC/so7Nu+tlZJ9m3WXE9o+A==";

// quick and simple:
echo '<img src="'.(new QRCode($options))->render($data).'" alt="QR Code" />';