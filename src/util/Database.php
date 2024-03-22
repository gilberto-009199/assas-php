<?php

namespace MyApplication\util{

    use PDO;
    use PDOException;

    class Database {

        private static $instance;
        private $hasConnected = false;
        public $pdo;

        public function __construct() {
            $this->connect();
        }

        public function enabled(){
            return $this->hasConnected;
        }

        private function connect() {

            try {

                // Recuperando as credenciais do banco de dados do ambiente
                $dbHost = $_ENV['DB_HOST'];
                $dbName = $_ENV['DB_NAME'];
                $dbUser = $_ENV['DB_USER'];
                $dbPass = $_ENV['DB_PASS'];

                // Criando uma conexão PDO com o banco de dados
                $this->pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

                // Configurando o PDO para lançar exceções em caso de erros
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // run select for verify
                $sql = "SELECT * FROM tbl_clientes limit 1";
                $stmt = $this->pdo->query($sql);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $this->hasConnected = true;

            } catch (PDOException $e) {
                // Em um ambiente real, você pode querer lidar com o erro de conexão de alguma forma
                // Por exemplo, lançar uma exceção personalizada ou logar o erro
                //die("Erro ao conectar ao banco de dados: " . $e->getMessage());
                $this->hasConnected = false;
            }
        }

        public function getConnection() {
            return $this->pdo;
        }

        public static function getInstance() {
            if(!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }

}
