<?php
require_once 'model/Mesa.php';

class MesaController {
    private $mesaModel;

    public function __construct() {
        $this->mesaModel = new Mesa();
    }



    // O store agora salva a mesa e te joga de volta pro PAINEL DO CEO
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero = $_POST['numero'];
            $capacidade = $_POST['capacidade'];

            $this->mesaModel->criar($numero, $capacidade);
            
            // REDIRECIONA PARA O PAINEL DO CEO!
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