<?php

declare(strict_types=1);

require_once __DIR__ . '/../model/Funcionarios.php';

class FuncionariosController
{
    private Funcionarios $funcionariosModel;

    public function __construct()
    {
        $this->funcionariosModel = new Funcionarios();
    }
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        // Pega o que foi digitado na tela
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        // VERIFICAÇÃO FIXA: Usuário 'admin' e Senha '123456'
        if ($usuario === 'admin' && $senha === '123456') {

            // Cria a sessão de administrador
            $_SESSION['usuario_id'] = 1;
            $_SESSION['usuario_nome'] = 'Administrador';
            $_SESSION['nivel_acesso'] = 'admin';

            // Redireciona para o painel de pedidos
            header('Location: index.php?controller=pedido&action=index');
            exit;
        } else {
            // Se errar a palavra admin ou a senha 123456, mostra o erro e volta
            echo "<script>
                    alert('Usuário ou senha incorretos!');
                    window.location.href = 'index.php?page=login';
                  </script>";
            exit;
        }
    }

    public function index(): void
    {
        $funcionarios = $this->funcionariosModel->listarTodos();

        $viewFile = __DIR__ . '/../view/funcionarios/index.php';
        if (file_exists($viewFile)) {
            require $viewFile;
            return;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($funcionarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function show(): void
    {
        $id          = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $funcionario = $this->funcionariosModel->buscarPorId($id);

        $viewFile = __DIR__ . '/../view/funcionarios/show.php';
        if (file_exists($viewFile)) {
            $funcionarioView = $funcionario;
            require $viewFile;
            return;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($funcionario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $senha     = $_POST['senha'] ?? '';
        $senhaHash = $senha !== '' ? password_hash($senha, PASSWORD_DEFAULT) : '';

        $dados = [
            'nome'         => $_POST['nome'] ?? '',
            'email'        => $_POST['email'] ?? '',
            'senha_hash'   => $senhaHash,
            'nivel_acesso' => $_POST['nivel_acesso'] ?? 'garcom',
            'ativo'        => isset($_POST['ativo']) ? (int) $_POST['ativo'] : 1,
        ];

        $id = $this->funcionariosModel->criar($dados);

        header('Location: /index.php?controller=funcionarios&action=show&id=' . $id);
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

        $senha     = $_POST['senha'] ?? '';
        $senhaHash = $senha !== '' ? password_hash($senha, PASSWORD_DEFAULT) : null;

        $dados = [
            'nome'         => $_POST['nome'] ?? '',
            'email'        => $_POST['email'] ?? '',
            'nivel_acesso' => $_POST['nivel_acesso'] ?? 'garcom',
            'ativo'        => isset($_POST['ativo']) ? (int) $_POST['ativo'] : 1,
        ];

        if ($senhaHash !== null) {
            $dados['senha_hash'] = $senhaHash;
        }

        $this->funcionariosModel->atualizar($id, $dados);

        header('Location: /index.php?controller=funcionarios&action=show&id=' . $id);
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
        $this->funcionariosModel->deletar($id);

        header('Location: /index.php?controller=funcionarios&action=index');
        exit;
    }
}

