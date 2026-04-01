<?php
require_once 'config/conexao.php';

class Mesa {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConnection();
    }

    // ==========================================
    // CORRIGIDO: Agora recebe o array $dados e salva o código de acesso!
    // ==========================================
    public function criar($dados) {
        $sql = "INSERT INTO mesas (numero, capacidade, status, codigo_acesso) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute([
            $dados['numero'], 
            $dados['capacidade'], 
            $dados['status'], 
            $dados['codigo_acesso']
        ]);
    }

    // Lista todas as mesas em ordem crescente
    public function listarTodas() {
        $sql = "SELECT * FROM mesas ORDER BY numero ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Apaga uma mesa do sistema
    public function excluir($id) {
        $sql = "DELETE FROM mesas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function atualizarStatusPorNumero($numero, $status)
    {
        $sql = "UPDATE mesas SET status = ? WHERE numero = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $numero]);
    }

    // Busca a mesa pelo código digitado pelo cliente
    public function buscarPorCodigo($codigo) {
        $sql = "SELECT * FROM mesas WHERE codigo_acesso = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([strtoupper($codigo)]); // strtoupper para não dar erro de maiúscula/minúscula
        return $stmt->fetch();
    }
}
?>