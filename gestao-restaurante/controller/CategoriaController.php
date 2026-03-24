<?php
require_once 'config/conexao.php';

class CategoriaController
{

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome']);

            if (!empty($nome)) {
                $pdo = Conexao::getConnection();
                $stmt = $pdo->prepare("INSERT INTO categorias (nome) VALUES (?)");
                $stmt->execute([$nome]);
            }
            header('Location: index.php?controller=admin&action=index');
            exit;
        }
    }

    public function deletar(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pdo = Conexao::getConnection();
            $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
            $stmt->execute([$id]);
        }
        header('Location: index.php?controller=admin&action=index');
        exit;
    }
    // Função para Editar Categoria
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');

            if ($id && !empty($nome)) {
                $pdo = Conexao::getConnection();
                $stmt = $pdo->prepare("UPDATE categorias SET nome = ? WHERE id = ?");
                $stmt->execute([$nome, $id]);
            }
            header('Location: index.php?controller=admin&action=index');
            exit;
        }
    }
}
