<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background-color: #F8F9FA;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: sans-serif;
        }

        .success-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background-color: #28a745;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 20px auto;
        }

        .text-muted {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="success-card">
        <div class="icon-circle">
            <i class="ph ph-check-fat"></i>
        </div>
        <h2 class="fw-bold mb-3">Tudo Certo!</h2>
        <p class="text-muted mb-4">Seu pedido foi enviado para a cozinha com sucesso. Por favor, aguarde em sua mesa.</p>
        <button onclick="fazerNovoPedido()" class="btn btn-lg fw-bold" style="background-color: #D32F2F; color: white;">
            Fazer Novo Pedido
        </button>

        <script>
            // 1. Limpa o carrinho e a observação antiga para o novo pedido não ir duplicado!
            localStorage.removeItem('carrinho_celestina');
            localStorage.removeItem('obs_celestina');

            // 2. Função inteligente para voltar pro cardápio
            function fazerNovoPedido() {
                const mesaSalva = localStorage.getItem('mesa_celestina');
                if (mesaSalva) {
                    // Se ele já tem a mesa, pula a tela inicial e vai direto pro cardápio dele!
                    window.location.href = 'index.php?page=cardapio&mesa=' + mesaSalva;
                } else {
                    window.location.href = 'index.php?page=home';
                }
            }
        </script>
        </a>
    </div>
</body>

</html>