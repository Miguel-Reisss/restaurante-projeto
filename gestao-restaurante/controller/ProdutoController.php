<?php

declare(strict_types=1);

require_once __DIR__ . '/../model/Produto.php';

class ProdutoController
{
    private Produto $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
    }

    /**
     * Lista todos os produtos.
     * Rota sugerida: index.php?controller=produto&action=index
     */
    public function index(): void
    {
        $produtos = $this->produtoModel->listarTodos();

        $viewFile = __DIR__ . '/../view/produtos/index.php';
        if (file_exists($viewFile)) {
            require $viewFile;
            return;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Exibe detalhes de um produto.
     * Rota: index.php?controller=produto&action=show&id=1
     */
    public function show(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $produto = $this->produtoModel->buscarPorId($id);

        $viewFile = __DIR__ . '/../view/produtos/show.php';
        if (file_exists($viewFile)) {
            $produtoView = $produto;
            require $viewFile;
            return;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($produto, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Cria um novo produto (tratando POST).
     * Rota: POST index.php?controller=produto&action=store
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $dados = [
            'nome'         => $_POST['nome'] ?? '',
            'descricao'    => $_POST['descricao'] ?? '',
            'preco'        => (float) ($_POST['preco'] ?? 0),
            'categoria_id' => isset($_POST['categoria_id']) ? (int) $_POST['categoria_id'] : null,
            'ativo'        => isset($_POST['ativo']) ? (int) $_POST['ativo'] : 1,
        ];

        $id = $this->produtoModel->criar($dados);

        header('Location: /index.php?controller=produto&action=show&id=' . $id);
        exit;
    }

    /**
     * Atualiza um produto existente.
     * Rota: POST index.php?controller=produto&action=update&id=1
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        $dados = [
            'nome'         => $_POST['nome'] ?? '',
            'descricao'    => $_POST['descricao'] ?? '',
            'preco'        => (float) ($_POST['preco'] ?? 0),
            'categoria_id' => isset($_POST['categoria_id']) ? (int) $_POST['categoria_id'] : null,
            'ativo'        => isset($_POST['ativo']) ? (int) $_POST['ativo'] : 1,
        ];

        $this->produtoModel->atualizar($id, $dados);

        header('Location: /index.php?controller=produto&action=show&id=' . $id);
        exit;
    }

    /**
     * Remove um produto.
     * Rota: POST index.php?controller=produto&action=delete&id=1
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->produtoModel->deletar($id);

        header('Location: /index.php?controller=produto&action=index');
        exit;
    }
}

