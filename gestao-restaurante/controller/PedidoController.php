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
        
        // NOVO: Buscar as mesas para o modal do garçom
        require_once 'config/conexao.php';
        $pdo = Conexao::getConnection();
        $stmt = $pdo->query("SELECT numero, capacidade, status, codigo_acesso FROM mesas ORDER BY numero ASC");
        $mesas = $stmt->fetchAll();
        
        require 'view/pedidos/index3.php';
    }
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Pega o número da mesa (Ex: 10)
            $numero_mesa_post = preg_replace('/[^0-9]/', '', $_POST['mesa_id'] ?? '');
            $numero_mesa = !empty($numero_mesa_post) ? (int)$numero_mesa_post : 1;

            // ==========================================
            // CORREÇÃO: BUSCA O ID REAL DA MESA NO BANCO
            // ==========================================
            require_once 'config/conexao.php';
            $pdo = Conexao::getConnection();
            $stmtMesa = $pdo->prepare("SELECT id FROM mesas WHERE numero = ?");
            $stmtMesa->execute([$numero_mesa]);
            $mesaReal = $stmtMesa->fetch();

            if (!$mesaReal) {
                echo "<script>alert('Erro: Mesa não encontrada no sistema!'); window.history.back();</script>";
                exit;
            }
            // Esse é o ID verdadeiro que o banco exige! (Ex: 12)
            $id_real_mesa = $mesaReal['id'];

            // ==========================================
            // NOVA LÓGICA: MONTA O RESUMO DOS ITENS
            // ==========================================
            $itensResumo = "";
            if (!empty($_POST['carrinho_json'])) {
                $carrinho = json_decode($_POST['carrinho_json'], true);
                if (is_array($carrinho)) {
                    foreach ($carrinho as $nome => $item) {
                        $itensResumo .= $item['qtd'] . "x " . $nome . "\n";
                    }
                }
            }
            $itensResumo = trim($itensResumo);

            // ==========================================
            // LIMPANDO A OBSERVAÇÃO
            // ==========================================
            $observacaoCliente = $_POST['observacoes'] ?? '';

            if (stripos($observacaoCliente, 'Obs:') !== false) {
                $partes = preg_split('/obs:/i', $observacaoCliente);
                $observacaoCliente = trim(end($partes));
            } elseif (trim($observacaoCliente) === $itensResumo) {
                $observacaoCliente = '';
            } else {
                $observacaoCliente = trim(str_replace($itensResumo, '', $observacaoCliente));
            }

            $dados = [
                'id_mesa' => $id_real_mesa, // AQUI NÓS SALVAMOS O ID VERDADEIRO!
                'tipo' => $_POST['tipo'] ?? '',
                'status' => 'aberto',
                'total' => round(floatval($_POST['total']), 2),
                'observacoes' => $observacaoCliente, 
                'itens_resumo' => $itensResumo       
            ];

            try {
                // 1. Cria o Pedido
                $pedido_id = $this->pedidoModel->criar($dados);

                // 2. Cria o Pagamento
                $metodo = $_POST['metodo_pagamento'] ?? 'Não informado';
                $troco = !empty($_POST['troco_para']) ? floatval($_POST['troco_para']) : null;
                $this->pedidoModel->salvarPagamento($pedido_id, $metodo, $dados['total'], $troco);

                // 3. Salva os lanches 
                if (isset($carrinho) && is_array($carrinho)) {
                    foreach ($carrinho as $nome => $item) {
                        $subtotal = $item['preco'] * $item['qtd'];
                        $this->pedidoModel->salvarItem($pedido_id, 0, $item['qtd'], $subtotal, $nome);
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
