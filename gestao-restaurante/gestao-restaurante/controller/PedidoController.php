<?php

declare(strict_types=1);

require_once __DIR__ . '/../model/Pedido.php';

class PedidoController
{
    private Pedido $pedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new Pedido();
    }

    public function index(): void
    {
        $status = $_GET['status'] ?? null;
        $tipo   = $_GET['tipo'] ?? null;

        $pedidos = $this->pedidoModel->listar($status, $tipo);

        $viewFile = __DIR__ . '/../view/pedidos/index.php';
        if (file_exists($viewFile)) {
            require $viewFile;
            return;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($pedidos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show(): void
    {
        $id     = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $pedido = $this->pedidoModel->buscarPorId($id);

        $viewFile = __DIR__ . '/../view/pedidos/show.php';
        if (file_exists($viewFile)) {
            $pedidoView = $pedido;
            require $viewFile;
            return;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($pedido, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $dados = [
            'mesa_id'     => isset($_POST['mesa_id']) ? (int) $_POST['mesa_id'] : null,
            'tipo'        => $_POST['tipo'] ?? 'salao',
            'status'      => $_POST['status'] ?? 'aberto',
            'total'       => (float) ($_POST['total'] ?? 0),
            'observacoes' => $_POST['observacoes'] ?? '',
        ];

        $id = $this->pedidoModel->criar($dados);

        // Manda o cliente de volta pro Início com um alerta de sucesso
        echo "<script>
                alert('Pedido realizado com sucesso! Aguarde em sua mesa.');
                window.location.href = 'index.php?page=home';
              </script>";
        exit;
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        $dados = [
            'mesa_id'     => isset($_POST['mesa_id']) ? (int) $_POST['mesa_id'] : null,
            'tipo'        => $_POST['tipo'] ?? 'salao',
            'status'      => $_POST['status'] ?? 'aberto',
            'total'       => (float) ($_POST['total'] ?? 0),
            'observacoes' => $_POST['observacoes'] ?? '',
        ];

        $this->pedidoModel->atualizar($id, $dados);

        header('Location: /index.php?controller=pedido&action=show&id=' . $id);
        exit;
    }

    public function atualizarStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $id     = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $status = $_POST['status'] ?? 'aberto';

        $this->pedidoModel->atualizarStatus($id, $status);

        // Volta para a lista de pedidos após salvar!
        header('Location: /index.php?controller=pedido&action=index');
        exit;
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->pedidoModel->deletar($id);

        header('Location: /index.php?controller=pedido&action=index');
        exit;
    }
}

