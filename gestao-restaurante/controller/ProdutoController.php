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

   public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $categoria_id = $_POST['categoria_id'];
            
            // Pega os preços (se o campo estiver vazio, envia NULL ou 0)
            $preco = !empty($_POST['preco']) ? str_replace(',', '.', $_POST['preco']) : 0;
            $tem_tamanhos = isset($_POST['tem_tamanhos']) ? 1 : 0;

            // $preco_p = !empty($_POST['preco_p']) ? str_replace(',', '.', $_POST['preco_p']) : null;
            // $preco_m = !empty($_POST['preco_m']) ? str_replace(',', '.', $_POST['preco_m']) : null;
            // $preco_g = !empty($_POST['preco_g']) ? str_replace(',', '.', $_POST['preco_g']) : null;

            $imagem_nome = 'placeholder.png'; 

            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
                $imagem_nome = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $nome) . '.' . $extensao;
                $diretorio_destino = 'view/midia/uploads/';
                
                if (!is_dir($diretorio_destino)) {
                    mkdir($diretorio_destino, 0777, true);
                }
                move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio_destino . $imagem_nome);
            }

            if($tem_tamanhos == 1 || $tem_tamanhos == true){
                $this->produtoModel->criarValoresTamanho([ 'preco_p' => $_POST['preco_p'], 'preco_m' => $_POST['preco_m'], 'preco_g' => $_POST['preco_g']]);
            }
            else{
                // Envia tudo pro banco!
                $this->produtoModel->criar($nome, $descricao, $preco, $categoria_id, $imagem_nome, $tem_tamanhos);
            }
            
            header('Location: index.php?controller=admin&action=index');
            exit;
        }
    }

    public function toggleStatus(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->produtoModel->alternarStatus($id);
        }
       header('Location: index.php?controller=admin&action=index');
        exit;
    }

    public function deletar(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->produtoModel->excluir($id);
        }
       header('Location: index.php?controller=admin&action=index');
        exit;
    }
}
