<?php
require_once 'config/conexao.php';

class AdminController {
    
    public function index(): void {
        $pdo = Conexao::getConnection();

        // O Super Controller busca TUDO do banco de uma vez só para o seu Painel Central!
        $produtos = $pdo->query("SELECT * FROM produtos ORDER BY id DESC")->fetchAll();
        $mesas = $pdo->query("SELECT * FROM mesas ORDER BY numero ASC")->fetchAll();
        $categorias = $pdo->query("SELECT * FROM categorias ORDER BY id DESC")->fetchAll();
        $funcionarios = $pdo->query("SELECT * FROM funcionarios ORDER BY id DESC")->fetchAll();

        // Carrega a Super Tela
        require 'view/admin_painel.php';
    }
}
?>