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

        // Pega o que foi digitado na tela (o campo ainda chama 'usuario' no formulário, mas agora ele recebe o e-mail)
        $email = trim($_POST['usuario'] ?? '');
        $senha = $_POST['senha'] ?? '';

        // 1. Busca o funcionário no banco de dados usando o e-mail
        $funcionario = $this->funcionariosModel->buscarPorEmail($email);

        // 2. Verifica se achou alguém e se a senha bate
        // NOTA: O password_verify checa a senha nova (criptografada), 
        // e o '===' checa a senha do admin se ela tiver sido criada manualmente sem criptografia.
        if ($funcionario && (password_verify($senha, $funcionario['senha_hash']) || $senha === $funcionario['senha_hash'])) {
            
            // Inicia a sessão se não estiver iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Cria a sessão com os dados reais do banco
            $_SESSION['usuario_id'] = $funcionario['id'];
            $_SESSION['usuario_nome'] = $funcionario['nome'];
            $_SESSION['nivel_acesso'] = $funcionario['nivel_acesso'];

            // Se for admin, vai pro painel do CEO. Se for garçom/caixa, vai pra tela de Pedidos Ativos.
            if ($funcionario['nivel_acesso'] === 'admin') {
                header('Location: index.php?controller=admin&action=index');
            } else {
                header('Location: index.php?controller=pedido&action=index');
            }
            exit;
            
        } else {
            // Se errar a senha ou e-mail, mostra o erro e volta
            echo "<script>
                    alert('E-mail ou senha incorretos!');
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

        header('Location: index.php?controller=admin&action=index');
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

       header('Location: index.php?controller=admin&action=index');
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

        header('Location: index.php?controller=admin&action=index');
        exit;
    }
}