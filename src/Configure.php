<?php



namespace MyApplication{

    use MyApplication\util\Database;
    use MyApplication\models\DAO;
    use MyApplication\services\SaleService;
    use MyApplication\services\AssasService;

    class Configure {

        private static $instance;

        public $db;
        public $dao;
        public $sales;
        public $assas;

        public function __construct() {
            $this->db       = Database::getInstance();
            $this->dao      = DAO::getInstance();
            $this->sales    = SaleService::getInstance();
            $this->assas    = AssasService::getInstance();
        }

        public static function readResponse(){

            $json = file_get_contents('php://input');

            // Decodificar o JSON para um array associativo
            $data = json_decode($json, true);

            // Verificar se o JSON foi decodificado com sucesso
            if ($data === null) {
                // Se houve um erro ao decodificar o JSON
                exit(1);

            } else return $data;

                // Se o JSON foi decodificado com sucesso, você pode acessar os dados
                // Faça o que precisar com os dados recebidos
                //var_dump($data); // Isso exibirá os dados para fins de depuração
            
        }

        public static function DB(){
            $config = Configure::getInstance();
            return $config->db;
        }

        public static function DAO(){
            $config = Configure::getInstance();
            return $config->dao;
        }

        public static function SALES(){
            $config = Configure::getInstance();
            return $config->sales;
        }

        public static function ASSAS(){
            $config = Configure::getInstance();
            return $config->assas;
        }

        public static function enabled(){

            $config = Configure::getInstance();

            // verify db enabled
            if(!$config->db->enabled())return false;

            // verify assas enabled
            if(!$config->assas->enabled())return false;
            
            // verify sale enabled
            if(!$_ENV['PROPHETA_SALE']) return false;

            return true;
        }

        public static function getInstance() {
            if(!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }

}
