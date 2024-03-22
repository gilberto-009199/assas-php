<?php


require_once __DIR__ . '/vendor/autoload.php';

/* */
// Dados a serem incluídos no JSON

$mac = "E2D3.9CFC.C560.8D69";
$mac = "df:a9:99";

$data = "$mac";

// Converter o array associativo em JSON

// Carregar a chave privada
$private_key = openssl_pkey_get_private("file://private.pem");

// Assinar os dados JSON
openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA256);

// Codificar a assinatura em base64
$signature_base64 = base64_encode($signature);

// Criar um array associativo contendo o JSON e a assinatura
$encrypted = "";
openssl_private_encrypt($data, $encrypted, $private_key);

// Base64 encode o texto criptografado para evitar problemas com caracteres especiais
$encryptedBase64 = base64_encode($encrypted);


// Converter o array associativo em JSON
echo "<br>Data: <br>";
echo $data;

echo "<br>Encript: <br>";
echo $encrypted;

echo "<br>Encript base64: <br>";
echo $encryptedBase64;

echo "<br>Signature: <br>";
echo $signature;

echo "<br>Signature Base64: <br>";
echo $signature_base64;
echo "<br>";
// Fechar a chave privada
openssl_free_key($private_key);
/* */


use chillerlan\QRCode\{QRCode, QROptions};


$options = new QROptions;



$options->version           = 10;
$options->scale             = 5;
$options->outputBase64      = true;
$options->imageTransparent  = true;

$data = $mac;//"{'mac':'$mac','license':'24589','signature':'$signature_base64'}";

// quick and simple:
echo '<img id="qrcode" width="300" src="'.(new QRCode($options))->render($encrypted).'" alt="QR Code" />';
?>
<button onclick="download()">Downlaod</button>
<script>
    function baixarImagemBase64(base64String, nomeArquivo) {
        // Cria um elemento <a> temporário
        var link = document.createElement('a');
        link.href = base64String;

        // Define o atributo "download" com o nome do arquivo desejado
        link.download = nomeArquivo;

        // Adiciona o elemento ao DOM
        document.body.appendChild(link);

        // Aciona o clique no link para iniciar o download
        link.click();

        // Remove o elemento <a> do DOM após o download
        document.body.removeChild(link);
    }

    function download(){

        // Exemplo de uso
        var imagem = document.getElementById('qrcode');

        var imagemBase64 = imagem.src; // Sua string base64 aqui
        var nomeArquivo = "<?=$mac?>.svg"; // Nome do arquivo

        baixarImagemBase64(imagemBase64, nomeArquivo);

    }
</script>