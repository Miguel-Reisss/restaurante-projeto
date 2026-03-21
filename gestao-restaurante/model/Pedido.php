<?php
require_once 'config/conexao.php';

class Pedido {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConnection();
    }

    // 1. Cria o Pedido (já com a correção do id_mesa)
    public function criar($dados) {
        $sql = "INSERT INTO pedidos (id_mesa, tipo, status, total, observacoes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $dados['id_mesa'], $dados['tipo'], $dados['status'], $dados['total'], $dados['observacoes']
        ]);
        return $this->conn->lastInsertId(); // Retorna o ID gerado
    }

    // 2. Salva o Pagamento na tabela nova
    public function salvarPagamento($id_pedido, $metodo, $valor, $troco_para) {
        $sql = "INSERT INTO pagamentos (id_pedido, metodo, valor, troco_para) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_pedido, $metodo, $valor, $troco_para]);
    }

    // 3. A FUNÇÃO QUE ESTAVA FALTANDO: Salva os lanches na tabela itens_pedido
    public function salvarItem($id_pedido, $id_produto, $quantidade, $subtotal) {
        $sql = "INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, subtotal) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_pedido, $id_produto, $quantidade, $subtotal]);
    }

    // Lista os pedidos para o painel do Admin
    public function listarTodos() {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Atualiza o status (Preparando, Pronto...)
    public function atualizarStatus($id, $status) {
        $sql = "UPDATE pedidos SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // Limpa os pedidos finalizados
    public function limparEntregues() {
        $sql = "DELETE FROM pedidos WHERE status = 'entregue'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
}
?>