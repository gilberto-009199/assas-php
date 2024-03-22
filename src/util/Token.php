<?php


namespace MyApplication\util{


    use \Firebase\JWT\JWT;
    
    // Chave secreta para assinar o token
    

    class Token {

        public static function generete($data){
            $secret_key = "ChapaDeAcoFolicoTranladadoOPorLaminaDeDiamante2569@";
            $alg = "HS256";

            return JWT::encode($data, $secret_key, $alg);
        }

        public static function getData($token){
            try {

                $secret_key = "ChapaDeAcoFolicoTranladadoOPorLaminaDeDiamante2569@";
                $alg = "HS256";
                // Decodificando e validando o token com o algoritmo HS256
                $decoded = JWT::decode($token, $secret_key, array($alg));

                // Se o token for válido
                return $decoded;
            } catch (Exception $e) {
                // Se o token for inválido ou expirado
                return false;
            }
        }
    }

}
