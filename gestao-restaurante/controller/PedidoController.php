<?php
require_once 'model/Pedido.php';

class PedidoController
{
    private $pedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new Pedido();
    }

    public function index(): void
    {
        $pedidos = $this->pedidoModel->listarTodos();
        require 'view/pedidos/index.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. CORREÇÃO DA MESA: Garante que só passa o número para o banco (ex: "Mesa 12" vira 12)
            $id_mesa = preg_replace('/[^0-9]/', '', $_POST['mesa_id'] ?? '');

            $dados = [
                // Se a mesa vier vazia, assume mesa 1 por padrão para não dar erro de NULL
                'id_mesa' => !empty($id_mesa) ? (int)$id_mesa : 1,
                'tipo' => $_POST['tipo'] ?? 'salao',
                'status' => 'aberto',
                'total' => round(floatval($_POST['total']), 2),
                'observacoes' => $_POST['observacoes'] ?? ''
            ];

            try {
                // 1. Cria o Pedido na tabela 'pedidos'
                $pedido_id = $this->pedidoModel->criar($dados);

                // 2. Cria o Pagamento na tabela 'pagamentos'
                $metodo = $_POST['metodo_pagamento'] ?? 'Não informado';
                $troco = !empty($_POST['troco_para']) ? floatval($_POST['troco_para']) : null;
                $this->pedidoModel->salvarPagamento($pedido_id, $metodo, $dados['total'], $troco);

                // 3. CORREÇÃO DOS ITENS: Salva os lanches na tabela 'itens_pedido'
                if (!empty($_POST['carrinho_json'])) {
                    $carrinho = json_decode($_POST['carrinho_json'], true);
                    if (is_array($carrinho)) {
                        foreach ($carrinho as $nome => $item) {
                            $subtotal = $item['preco'] * $item['qtd'];

                            // Por enquanto enviamos o ID do produto como 0 (até atualizarmos o cardápio do cliente)
                            $this->pedidoModel->salvarItem($pedido_id, 0, $item['qtd'], $subtotal);
                        }
                    }
                }

                // 4. Redireciona para a tela de Sucesso Bonita!
                header('Location: index.php?page=sucesso');
                exit;
            } catch (Exception $e) {
                echo "Erro ao salvar pedido: " . $e->getMessage();
            }
        }
    }

    public function atualizarStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? null;
            $status = $_POST['status'] ?? null;

            if ($id && $status) {
                $this->pedidoModel->atualizarStatus($id, $status);
            }
            header('Location: index.php?controller=pedido&action=index');
            exit;
        }
    }

    // NOVA AÇÃO: Chama a função de limpar e recarrega a página
    public function limparEntregues(): void
    {
        $this->pedidoModel->limparEntregues();
        header('Location: index.php?controller=pedido&action=index');
        exit;
    }
}
