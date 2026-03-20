<?php
require_once 'config/conexao.php';

class Pedido
{
    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getConnection();
    }

    public function criar($dados)
    {
        $sql = "INSERT INTO pedidos (id_mesa, tipo, status, total, observacoes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $dados['id_mesa'],
            $dados['tipo'],
            $dados['status'],
            $dados['total'],
            $dados['observacoes']
        ]);
        return $this->conn->lastInsertId(); // Retorna o ID do pedido que acabou de ser criado!
    }

    // NOVA FUNÇÃO: Salva o pagamento na tabela separada
    public function salvarPagamento($pedido_id, $metodo, $valor, $troco_para)
    {
        $sql = "INSERT INTO pagamentos (id_pedido, metodo, valor, troco_para) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$pedido_id, $metodo, $valor, $troco_para]);
    }

    public function listarTodos()
    {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function atualizarStatus($id, $status)
    {
        $sql = "UPDATE pedidos SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // NOVA FUNÇÃO: Apaga todos os pedidos que já foram entregues
    public function limparEntregues()
    {
        // Como você colocou ON DELETE CASCADE na tabela de pagamentos, 
        // os pagamentos destes pedidos também serão limpos automaticamente.
        $sql = "DELETE FROM pedidos WHERE status = 'entregue'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
}
