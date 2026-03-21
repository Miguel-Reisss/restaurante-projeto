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
}
?>