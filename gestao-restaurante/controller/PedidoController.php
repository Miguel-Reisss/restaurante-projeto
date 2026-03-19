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

            $dados = [
                'mesa_id' => $_POST['mesa_id'] ?? null,
                'tipo' => $_POST['tipo'] ?? 'salao',
                'status' => 'aberto',
                'total' => round(floatval($_POST['total']), 2),
                'observacoes' => $_POST['observacoes'] ?? ''
            ];

            try {
                // 1. Cria o Pedido
                $pedido_id = $this->pedidoModel->criar($dados);

                // 2. Cria o Pagamento na tabela nova
                $metodo = $_POST['metodo_pagamento'] ?? 'Não informado';
                $troco = !empty($_POST['troco_para']) ? floatval($_POST['troco_para']) : null;
                $this->pedidoModel->salvarPagamento($pedido_id, $metodo, $dados['total'], $troco);

                // 3. Redireciona para a tela de Sucesso Bonita!
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
