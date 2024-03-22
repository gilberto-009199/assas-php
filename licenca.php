<?php

$userCode = "CD1BBF8E9BA2773D";
$encript_local_base = "eth408:62:66:df:a9:99";
$lengh_key_license = 24;
$KEY_CRYPTO = "aK6tBdwn80ZfkWMZ";

function encrypt($text) {
    try {
        $cipher = "aes-256-cbc"; // Algoritmo de criptografia AES-256 em modo CBC
        $ivLength = openssl_cipher_iv_length($cipher);
        $iv = str_repeat("\x00", $ivLength);//openssl_random_pseudo_bytes($ivLength); // Gera um IV (vetor de inicialização) aleatório
        
        $aesKey = openssl_digest($KEY_CRYPTO, 'SHA256', true);
        // Criptografa o texto usando a chave e o IV
        $encrypted = openssl_encrypt($text, $cipher, $aesKey, OPENSSL_RAW_DATA, $iv);

        // Codifica o texto criptografado em Base64
        $res = base64_encode($encrypted);

        return $res;
    } catch (Exception $e) {
        // Lida com exceções aqui
        throw new EncryptionException();
    }
}

function Myhash($str, $max) {
    switch ($max) {
        case 16: return hashLimitado16($str);
        case 24: return hashLimitado24($str);
        default: return hash($str);
    }
}

function hashLimitado16($str) {
    $hash = hash('sha512', $str);
    $data = str_split($hash);
    $newData = [];
    for ($k = 0; $k < ceil(count($data) / 8.0); $k++) {
        $newData[$k] = $data[($k * 8) + 7];
    }
    $newHash = implode('', $newData);
    return $newHash;
}

function hashLimitado24($str) {
    $hash = hash('sha384', $str);
    $data = str_split($hash);
    $newData = [];
    for ($k = 0; $k < ceil(count($data) / 4.0); $k++) {
        $newData[$k] = $data[($k * 4) + 1];
    }
    $newHash = implode('', $newData);
    return $newHash;
}

$result = encrypt("123456789");
echo "Resultado: $result";

/*


echo "+ userCode: " . $userCode . "<br>";

$a = str_split($userCode);
echo "+ Constants::ENCRYPT_LOCAL_BASE: <br>";
echo $encript_local_base . "<br>";

$b = str_split($encript_local_base);
$c = $a;
if (count($a) > count($b)) {
    $a = $b;
    $b = $c;
}
$c = array_merge([], array_map(null, $a, $b));

$encrypted = implode("", $c);

try {
    $encrypted = encrypt($encrypted);
} catch (EncryptionException $e) {
    echo $e->getMessage();
}
echo "+ encrypted: <br/>";
echo $encrypted;
echo "+ lengh_key_license: <br/>";
echo $lengh_key_license;

// esse 
$license = strtoupper( Myhash($encrypted, $lengh_key_license) );
echo "<br>+ Constants::LENGTH_KEY_LICENSE: " . $lengh_key_license . "<br>";
echo "+ license: " . $license . "<br>";

*/