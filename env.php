<?php

// heroku deploy ENV'S
if (getenv('JAWSDB_URL')) {
    $url = parse_url(getenv('JAWSDB_URL'));
    putenv('DB_HOST=' . $url['host']);
    putenv('DB_USER=' . $url['user']);
    putenv('DB_PASSWORD=' . $url['pass']);
    putenv('DB_NAME=' . ltrim($url['path'], '/'));
}

// Database Config
$_ENV['DB_HOST']        =   (getenv('DB_HOST')     ? getenv('DB_HOST')            : '127.0.0.1');
$_ENV['DB_NAME']        =   (getenv('DB_NAME')     ? getenv('DB_NAME')            : 'reinte33_payment');
$_ENV['DB_USER']        =   (getenv('DB_USER')     ? getenv('DB_USER')            : 'reinte33_payment_user');
$_ENV['DB_PASSWORD']    =   (getenv('DB_PASSWORD') ? getenv('DB_PASSWORD')        : 'GanheComSorteEGanheBem@!3r22234');


// Valor de compra do Propheta
$_ENV['PRODUCT_NAME']   = (getenv('PRODUCT_NAME') ? getenv('PRODUCT_NAME') : "Serviço De Hospedagem");
$_ENV['PRODUCT_PRICE']  = (getenv('PRODUCT_PRICE') ? getenv('PRODUCT_PRICE') : 6.30);
// Maximo de parcelas
$_ENV['PRODUCT_MAX_INSTALLMENTES'] = (getenv('PRODUCT_MAX_INSTALLMENTES') ? getenv('PRODUCT_MAX_INSTALLMENTES') : 1);
// Validar se vendas esta ativado
$_ENV['PRODUCT_SALE']   = (getenv('PRODUCT_SALE') ? getenv('PRODUCT_SALE') : true);

// Assas Config
$_ENV['ASSAS_API']  = (getenv('ASSAS_API')   ? getenv('ASSAS_API')   : '$aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjRiN2JiYzk4LTg0ZjUtNDVlMS1hZTU1LTFlODBkZGE1NDk0Yzo6JGFhY2hfZTNkMmU5YTctYmVmYS00MmNkLTgwMTgtMDliZTIxZmIzYTZi');
$_ENV['ASSAS_ENV']  = (getenv('ASSAS_ENV')   ? getenv('ASSAS_ENV')   : 'homologacao');

// Senha para validar webhook's
$_ENV['WEBHOOK']    = (getenv('WEBHOOK')     ? getenv('WEBHOOK')     : '');

// Email commecial
$_ENV['PRODUCT_MAIL_COMMERCIAL_SMTP']   = (getenv('PRODUCT_MAIL_COMMERCIAL_SMTP')    ? getenv('PRODUCT_MAIL_COMMERCIAL_SMTP')   : '');
$_ENV['PRODUCT_MAIL_COMMERCIAL']        = (getenv('PRODUCT_MAIL_COMMERCIAL')         ? getenv('PRODUCT_MAIL_COMMERCIAL')        : '');
$_ENV['PRODUCT_MAIL_COMMERCIAL_PASS']   = (getenv('PRODUCT_MAIL_COMMERCIAL_PASS')    ? getenv('PRODUCT_MAIL_COMMERCIAL_PASS')   : '');

