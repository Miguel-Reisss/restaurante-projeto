<?php
require_once 'config/conexao.php';

class Mesa {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConnection();
    }

    // Cria uma nova mesa no banco (por padrão, ela nasce com o status 'livre')
    public function criar($numero, $capacidade) {
        $sql = "INSERT INTO mesas (numero, capacidade, status) VALUES (?, ?, 'livre')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$numero, $capacidade]);
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
}
?>