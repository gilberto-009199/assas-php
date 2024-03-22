<?php

namespace MyApplication\services{

    use MyApplication\Configure;
    use MyApplication\util\Token;
    use MyApplication\util\Mailto;

    class SaleService {
        
        private static $instance;

        public function __construct() {}

        public static function hook($res){
            $event  = $res['event'];
            $data   = $res['payment'];

            switch($event){
                case "PAYMENT_CONFIRMED":
                    // aprovar a licensa e enviar o email
                    // caso o status esteja PAYMENT_CONFIRMED nao faça nada
                    
                    $cobrancaDAO = Configure::DAO()->getCobrancaByAssasId($data['id']);

                    Configure::DAO()->createCobrancaStatus($cobrancaDAO['id'], $cobrancaDAO['idClientes'], $event, $data);

                    if($cobrancaDAO['status'] == "PAYMENT_CONFIRMED")return;

                    Configure::DAO()->setCobrancaStatus($cobrancaDAO['id'], "PAYMENT_CONFIRMED");

                    // Criar licensa e JWT relativo a ela
                    $licensaId = Configure::DAO()->createLicense($cobrancaDAO['id'], $cobrancaDAO['idClientes']);

                    $token = Token::generete(array(
                        "licensaId" => $licensaId,
                        "idVendas" => $cobrancaDAO['id'],
                        "idClientes" => $cobrancaDAO['idClientes']
                    ));

                    $clienteDAO = Configure::DAO()->getClienteById($cobrancaDAO['idClientes']);
                    
                    Mailto::send($clienteDAO['email'], $clienteDAO['nomeRazaoSocial'], "[Propheta] Sua Licença Esta Pronta", "
                        Olá, ". $clienteDAO['nomeRazaoSocial'] ."<br>
                        
                            Confirmamos o seu pagamento! Acesse o link a baixo para pegar a licença:<br>
                            <a href='https://propheta.net/sales/licenca.php?token=$token'>https://propheta.net/sales/licenca?token=$token</a>
                            <br><br>
                        Comercial Propheta,<br>
                        suporte: <a src='mailto:suporte@propheta.net'>suporte@propheta.net</a><br>
                        site: <a src='https://propheta.net/'>https://propheta.net/</a>
                    ");

                    break;
                case "PAYMENT_CREDIT_CARD_CAPTURE_REFUSED":
                case "PAYMENT_REPROVED_BY_RISK_ANALYSIS":
                case "PAYMENT_CHARGEBACK_DISPUTE":
                case "PAYMENT_DUNNING_RECEIVED":
                case "PAYMENT_REFUNDED":
                case "PAYMENT_OVERDUE":
                    
                    $cobrancaDAO = Configure::DAO()->getCobrancaByAssasId($data['id']);

                    Configure::DAO()->createCobrancaStatus($cobrancaDAO['id'], $cobrancaDAO['idClientes'], $event, $data);

                    Configure::DAO()->setCobrancaStatus($cobrancaDAO['id'],  $event);

                    // cancelar a licensa e enviar o email

                    break;
                default:
                    // registrar no tbl_vendas_status
            }

        }

        public static function createSale($res){

            $cliente = array(
                "nomeRazaoSocial"   => $res['nomeRazaoSocial'],
                "cpfCnpj"           => $apenasNumeros = preg_replace('/[^0-9]/', '', $res['cpfCnpj']),
                "email"             => $res['email'],
                "inscricaoEstadual" => $res['inscricaoEstadual'],
                "telefoneCelular"   => $apenasNumeros = preg_replace('/[^0-9]/', '', $res['telefoneCelular']),
                "cep"               => $apenasNumeros = preg_replace('/[^0-9]/', '', $res['cep']),
                "cidade"            => $res['cidade'],
                "endereco"          => $res['endereco']
            );

            $billingTypes = array("CREDIT_CARD", "PIX", "BOLETO");

            if ( !isset($res['tipoPagamento']) || !in_array($res['tipoPagamento'], $billingTypes)){
                $res['tipoPagamento'] = 'UNDEFINED';
            }

            $cobranca = array(
                'produto'       => "Propheta licensa",
                'tipoPagamento' => $res['tipoPagamento'],
                'preco'         => $_ENV['PROPHETA_PRICE'],
                'vencimento'    => strtotime("+2 weeks", time())
            );

            $clienteDAO = Configure::DAO()->getClientOrCreate($cliente);

            $cobrancaDAO = Configure::DAO()->createCobranca( $clienteDAO['id'], $cobranca);

            $cobrancaAsas = Configure::ASSAS()->createPayment($clienteDAO, $cobrancaDAO);

            $assasClienteId = $cobrancaAsas->customer;
            $assasCobrancaId = $cobrancaAsas->id;

            Configure::DAO()->setAssasClientId($clienteDAO['id'], $assasClienteId);

            Configure::DAO()->setAssasCobrancaId($cobrancaDAO['id'], $assasCobrancaId);

            echo json_encode($cobrancaAsas);
        }

        public static function getInstance() {
            if(!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }

}
