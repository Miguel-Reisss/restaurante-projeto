<?php
require_once 'config/conexao.php';

class AdminController {
    
    public function index(): void {
        $pdo = Conexao::getConnection();

        // O Super Controller busca TUDO do banco de uma vez só para o seu Painel Central!
        $produtos = $pdo->query("SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id DESC")->fetchAll();
        $mesas = $pdo->query("SELECT * FROM mesas ORDER BY numero ASC")->fetchAll();
        $categorias = $pdo->query("SELECT * FROM categorias ORDER BY id DESC")->fetchAll();
        $funcionarios = $pdo->query("SELECT * FROM funcionarios ORDER BY id DESC")->fetchAll();

        // NOVA LINHA CORRIGIDA: Junta os pedidos com a tabela de mesas para pegar o "numero_da_mesa"
        $sqlPedidos = "SELECT pedidos.*, mesas.numero AS numero_da_mesa 
                       FROM pedidos 
                       LEFT JOIN mesas ON pedidos.id_mesa = mesas.id 
                       ORDER BY pedidos.id DESC LIMIT 50";
        $pedidos = $pdo->query($sqlPedidos)->fetchAll();

        // Carrega a Super Tela
        require 'view/admin_painel.php';
    }
}
?>