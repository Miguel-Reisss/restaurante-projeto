<?php
require_once 'model/Mesa.php';

class MesaController {
    private $mesaModel;

    public function __construct() {
        $this->mesaModel = new Mesa();
    }



    // O store agora salva a mesa e te joga de volta pro PAINEL DO CEO
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Pega os dados do formulário
            $numero = $_POST['numero'] ?? '';
            $capacidade = $_POST['capacidade'] ?? '';
            $codigo_acesso = trim($_POST['codigo_acesso'] ?? '');

            // 2. A MÁGICA: Se o campo código de acesso veio vazio, cria um aleatório!
            if (empty($codigo_acesso)) {
                // Gera 4 caracteres aleatórios (números e letras) em maiúsculo
                $codigo_acesso = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
            }

            // 3. Monta os dados para salvar no banco
            $dados = [
                'numero' => $numero,
                'capacidade' => $capacidade,
                'codigo_acesso' => $codigo_acesso,
                'status' => 'livre' // Toda mesa nova começa livre
            ];

            // 4. Salva no banco (usando o model) e volta pro painel
            require_once 'model/Mesa.php';
            $mesaModel = new Mesa();
            $mesaModel->criar($dados);

            header('Location: index.php?controller=admin&action=index');
            exit;
        }
    }

    public function acessarCardapio() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = $_POST['codigo'] ?? '';
            
            require_once 'model/Mesa.php';
            $mesaModel = new Mesa();
            $mesa = $mesaModel->buscarPorCodigo($codigo);

            if ($mesa) {
                // Código certo! Redireciona para o cardápio passando o número da mesa na URL (pro JS capturar)
                header("Location: index.php?page=cardapio&mesa=" . $mesa['numero']);
                exit;
            } else {
                // Código errado! Volta para a home com um alerta
                echo "<script>alert('Código inválido! Peça o código correto ao garçom.'); window.location.href='index.php?page=home';</script>";
                exit;
            }
        }
    }

    // O deletar agora apaga e te joga de volta pro PAINEL DO CEO
    public function deletar(): void {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->mesaModel->excluir($id);
        }
        // REDIRECIONA PARA O PAINEL DO CEO!
        header('Location: index.php?controller=admin&action=index');
        exit;
    }
    // O CEO clica no botão e a mesa volta a ficar livre!
    public function liberar(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pdo = Conexao::getConnection();
            $stmt = $pdo->prepare("UPDATE mesas SET status = 'livre' WHERE id = ?");
            $stmt->execute([$id]);
        }
        header('Location: index.php?controller=admin&action=index');
        exit;
    }
}
?>