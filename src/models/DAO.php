<?php

namespace MyApplication\models{

    require_once __DIR__ . '/../../env.php';

    use MyApplication\util\Database;
    use PDO;
    use PDOException;

    class DAO {

        private static $instance;
        public $db;

        private function __construct() {
            $this->db   =   Database::getInstance();
        }

        // UPDATE assasClienteId setASSAClientId(assaId, idCliente)
        public function setAssasClientId($clienteId, $assasClienteId){

            $stmt = $this->db->pdo->prepare("UPDATE tbl_clientes SET assasClienteId = :assasClienteId WHERE id = :id");

            $stmt->bindParam(':assasClienteId', $assasClienteId, PDO::PARAM_STR);
            $stmt->bindParam(':id', $clienteId, PDO::PARAM_INT);

            return $stmt->execute();
        }

        public function getCobrancaByAssasId($assasCobrancaId){
            $stmt = $this->db->pdo->prepare("SELECT * FROM tbl_vendas WHERE assasCobrancaId = :assasCobrancaId");
            
            $stmt->bindParam(':assasCobrancaId', $assasCobrancaId, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function setCobrancaStatus($cobrancaDAOId, $status){
            $stmt = $this->db->pdo->prepare("UPDATE tbl_vendas SET tbl_vendas.status = :status WHERE id = :id");

            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $cobrancaDAOId, PDO::PARAM_INT);

            return $stmt->execute();
        }

        public function setAssasCobrancaId($cobrancaId, $assasCobrancaId){

            $stmt = $this->db->pdo->prepare("UPDATE tbl_vendas SET assasCobrancaId = :assasCobrancaId WHERE id = :id");

            $stmt->bindParam(':assasCobrancaId', $assasCobrancaId, PDO::PARAM_STR);
            $stmt->bindParam(':id', $cobrancaId, PDO::PARAM_INT);

            return $stmt->execute();

        }

        public function createCobrancaStatus($idVendas, $idClientes, $status, $info){

            $sql = "INSERT INTO tbl_vendas_status(status, info, idVendas, idClientes)VALUES(:status, :info, :idVendas, :idClientes)";

            $stmt = $this->db->pdo->prepare($sql);

            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $json = json_encode($info);
            $stmt->bindParam(':info', $json, PDO::PARAM_STR);
            $stmt->bindParam(':idVendas', $idVendas, PDO::PARAM_INT);
            $stmt->bindParam(':idClientes', $idClientes, PDO::PARAM_INT);

            return $stmt->execute();
        }


        public function createLicense($idVendas, $idClientes){

            $sql = "INSERT INTO tbl_licensas(idVendas, idClientes)VALUES(:idVendas, :idClientes)";

            $stmt = $this->db->pdo->prepare($sql);

            $stmt->bindParam(':idVendas', $idVendas, PDO::PARAM_INT);
            $stmt->bindParam(':idClientes', $idClientes, PDO::PARAM_INT);

            $stmt->execute();

            return $this->db->pdo->lastInsertId();

        }

        public function createClient($cliente){

            $sql = "INSERT INTO tbl_clientes(nomeRazaoSocial, cpfCnpj, email, inscricaoEstadual, telefoneCelular, cep, cidade, endereco)VALUES( :nomeRazaoSocial, :cpfCnpj, :email, :inscricaoEstadual, :telefoneCelular, :cep, :cidade, :endereco )";

            $stmt = $this->db->pdo->prepare($sql);

            $stmt->bindParam(':nomeRazaoSocial', $cliente['nomeRazaoSocial'], PDO::PARAM_STR);
            $stmt->bindParam(':cpfCnpj', $cliente['cpfCnpj'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $cliente['email'], PDO::PARAM_STR);
            $stmt->bindParam(':inscricaoEstadual', $cliente['inscricaoEstadual'], PDO::PARAM_STR);
            $stmt->bindParam(':telefoneCelular', $cliente['telefoneCelular'], PDO::PARAM_STR);
            $stmt->bindParam(':cep', $cliente['cep'], PDO::PARAM_STR);
            $stmt->bindParam(':cidade', $cliente['cidade'], PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $cliente['endereco'], PDO::PARAM_STR);
            
            $stmt->execute();
            
            $cliente['id'] = $this->db->pdo->lastInsertId();

            return $cliente;
        }

        public function getClienteByMailAndCpfCnpj($email, $cpfCnpj) {
            $stmt = $this->db->pdo->prepare("SELECT * FROM tbl_clientes WHERE cpfCnpj = :cpfCnpj AND email = :email");
            $stmt->bindParam(':cpfCnpj', $cpfCnpj, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getClienteById($id) {
            $stmt = $this->db->pdo->prepare("SELECT * FROM tbl_clientes WHERE id = :id");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getVendasByClientId($idClientes) {
            
            $stmt = $this->db->pdo->prepare("SELECT * FROM tbl_vendas WHERE idClientes = :idClientes");

            $stmt->bindParam(':idClientes', $idClientes, PDO::PARAM_INT);

            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getClientOrCreate($cliente){

            $clienteDAO = $this->getClienteByMailAndCpfCnpj($cliente['email'], $cliente['cpfCnpj']);

            if(!$clienteDAO){

                return $this->createClient( $cliente );

            } else return $clienteDAO;

        }

        public function createCobranca($idClientes, $cobranca){

            $stmt = $this->db->pdo->prepare("INSERT INTO tbl_vendas(produto, tipoPagamento, preco, vencimento, idClientes)VALUES(:produto,:tipoPagamento,:preco,:vencimento,:idClientes)");

            $stmt->bindParam(':produto', $cobranca['produto'], PDO::PARAM_STR);
            $stmt->bindParam(':tipoPagamento', $cobranca['tipoPagamento'], PDO::PARAM_STR);
            $stmt->bindParam(':preco', $cobranca['preco'], PDO::PARAM_STR);
            $vencimento =  date('Y-m-d', $cobranca['vencimento']);
            $stmt->bindParam(':vencimento', $vencimento , PDO::PARAM_STR);
            $stmt->bindParam(':idClientes', $idClientes , PDO::PARAM_INT);
            
            $stmt->execute();
            
            $cobranca['id'] = $this->db->pdo->lastInsertId();

            return $cobranca;

        }

        

        public static function getInstance() {
            if(!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }

}
