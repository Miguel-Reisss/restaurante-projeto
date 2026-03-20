<?php
require_once 'model/Produto.php';

class ProdutoController
{
    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
    }

    public function index(): void
    {
        $produtos = $this->produtoModel->listarTodos();
        require 'view/admin_produtos.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $preco = str_replace(',', '.', $_POST['preco']);
            $categoria_id = $_POST['categoria_id'];
            $imagem_nome = 'placeholder.png';

            // Lógica de Upload Inteligente
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
                $imagem_nome = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $nome) . '.' . $extensao;

                $diretorio_destino = 'view/midia/uploads/';

                // MÁGICA AQUI: Se a pasta não existir, o PHP cria ela agora!
                if (!is_dir($diretorio_destino)) {
                    mkdir($diretorio_destino, 0777, true);
                }

                $destino = $diretorio_destino . $imagem_nome;
                move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
            }

            $this->produtoModel->criar($nome, $descricao, $preco, $categoria_id, $imagem_nome);
            header('Location: index.php?controller=produto&action=index');
            exit;
        }
    }

    public function toggleStatus(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->produtoModel->alternarStatus($id);
        }
        header('Location: index.php?controller=produto&action=index');
        exit;
    }

    public function deletar(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->produtoModel->excluir($id);
        }
        header('Location: index.php?controller=produto&action=index');
        exit;
    }
}
