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
        require 'view/pedidos/index3.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Pega o número da mesa
            $id_mesa = preg_replace('/[^0-9]/', '', $_POST['mesa_id'] ?? '');
            $numero_mesa = !empty($id_mesa) ? (int)$id_mesa : 1;

            $dados = [
                'id_mesa' => $numero_mesa,
                'tipo' => $_POST['tipo'] ?? '',
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

                // 3. Salva os lanches na tabela 'itens_pedido'
                if (!empty($_POST['carrinho_json'])) {
                    $carrinho = json_decode($_POST['carrinho_json'], true);
                    if (is_array($carrinho)) {
                        foreach ($carrinho as $nome => $item) {
                            $subtotal = $item['preco'] * $item['qtd'];
                            $this->pedidoModel->salvarItem($pedido_id, 0, $item['qtd'], $subtotal, $nome);
                        }
                    }
                }

                // ==========================================
                // 4. MÁGICA DA MESA: Muda o status para "ocupada"
                // ==========================================
                require_once 'model/Mesa.php';
                $mesaModel = new Mesa();
                $mesaModel->atualizarStatusPorNumero($numero_mesa, 'ocupada');

                // 5. Redireciona para a tela de Sucesso!
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
