<?php
require_once 'config/conexao.php';

class Produto
{
    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getConnection();
    }

    // Salva o produto novo no banco
    public function criar($nome, $descricao, $preco, $categoria_id, $imagem)
    {
        $sql = "INSERT INTO produtos (nome, descricao, preco, categoria_id, imagem, ativo) VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $descricao, $preco, $categoria_id, $imagem]);
    }

    // Lista todos os produtos para a tela do CEO
    public function listarTodos()
    {
        // Puxa o produto e também o nome da categoria dele
        $sql = "SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Botão mágico de Esgotado / Disponível
    public function alternarStatus($id)
    {
        // Se estiver 1 vira 0, se estiver 0 vira 1
        $sql = "UPDATE produtos SET ativo = NOT ativo WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Apaga o produto do banco
    public function excluir($id)
    {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
