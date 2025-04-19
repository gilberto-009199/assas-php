<?php


namespace MyApplication\services{

    use CodePhix\Asaas\Asaas;

    class AssasService {
        
        private static $instance;

        private $hasConnected = false;
        private $asa;

        public function __construct() {
            $this->connect();
        }
        public function getClientOrCreate($cliente){

            $result = $this->asa->Cliente()->getAll(array(
                "cpfCnpj" => $cliente['cpfCnpj'],
                "email" => $cliente['email']
            ));

            //if(isset($result->error) && !empty($result->error)){
            if(isset($result->data) && empty($result->data)){

                if(!isset($cliente['name']) || !isset($cliente['cpfCnpj']) || !isset($cliente['email']) ){

                    echo "Sem Email ou cpf ou email";

                }else return $this->asa->Cliente()->create($cliente);

            } else return $result->data[0];

        }
        
        /* Create Cobrança */
        public function createPayment($clienteDAO, $cobrancaDAO){

            $cliente = array(
                "name" => $clienteDAO['nomeRazaoSocial'],
                "cpfCnpj" => $apenasNumeros = preg_replace('/[^0-9]/', '', $clienteDAO['cpfCnpj']),
                "email" => $clienteDAO['email'],
                "municipalInscription" => $clienteDAO['inscricaoEstadual'],
                "phone" => $apenasNumeros = preg_replace('/[^0-9]/', '', $clienteDAO['telefoneCelular']),
                "postalCode" => $apenasNumeros = preg_replace('/[^0-9]/', '', $clienteDAO['cep']),
                "city" => $clienteDAO['cidade'],
                "address" => $clienteDAO['endereco']
            );

            $cobranca = array(
                'billingType' => (isset($cobrancaDAO['tipoPagamento']) ? $cobrancaDAO['tipoPagamento'] : ''),
                'value' => $cobrancaDAO['preco'],
                'dueDate' => isset($cobrancaDAO['vencimento']) ? $cobrancaDAO['vencimento'] : strtotime("+2 weeks", time())/* 2 semanas depois de hoje */,
                'description' => $cobrancaDAO['produto']
            );
            
            $cobranca['dueDate'] = date("Y-m-d", $cobranca['dueDate']);

            $clienteAsa = $this->getClientOrCreate($cliente);

            $billingTypes = array("CREDIT_CARD", "PIX", "BOLETO");

            if ( !isset($cobranca['billingType']) || !in_array($cobranca['billingType'], $billingTypes)){
                $cobranca['billingType'] = 'CREDIT_CARD';
            }

            $cobranca['customer'] = $clienteAsa->id;
            
            $cobranca['value'] = isset($cobrancaDAO['preco']) && $cobrancaDAO['preco'] > $_ENV['PRODUCT_PRICE'] ? $cobrancaDAO['preco'] : $_ENV['PRODUCT_PRICE'];

            /* Precisa definir o site em minhas informaçoes
            $cobranca['callback'] = [
                'autoRedirect' => true,
                'successUrl' => 'https://propheta.net/sales/success_payment.php'
            ];*/
            
            //echo json_encode($cobranca);

            return $this->asa->Cobranca()->create($cobranca);

        }
        
        private function connect() {

            try {

                $API_KEY = $_ENV['ASSAS_API'];
                $API_ENV = $_ENV['ASSAS_ENV'];

                $this->asa = new Asaas($API_KEY, $API_ENV ? $API_ENV : 'homologacao'); // 'producao|homologacao'
                
                $clientes = $this->asa->Cliente()->getAll([]);                

                $this->hasConnected = !isset($clientes->error) && empty($clientes->error);

            } catch (\Exception $e) {

                $this->hasConnected = false;
            }
        }

        public function enabled(){
            return $this->hasConnected;
        }

        public static function getInstance() {
            if(!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }

}
