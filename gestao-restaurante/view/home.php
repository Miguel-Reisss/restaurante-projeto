<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Sabor & Tempo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --bg-color: #F8F9FA;
            --text-color: #2B2D42;
            --card-bg: #ffffff;
            --border-color: #dee2e6;
            --header-text: #D32F2F;
        }

       

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, color 0.3s;
            margin: 0;
            position: relative;
            /* Necessário para o botão de tema fixo no canto */
        }

        /* Botão de tema no canto da tela */
        .btn-theme {
            background: transparent;
            border: none;
            color: var(--text-color);
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.2s;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .btn-theme:hover {
            transform: scale(1.1);
        }

        /* Cartão Centralizado */
        .home-card {
            background: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Título dentro do cartão */
        .home-card h2 {
            color: var(--header-text);
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .btn-custom {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .btn-cliente {
            background-color: #D32F2F;
            color: white;
            border: none;
        }

        .btn-cliente:hover {
            background-color: #b71c1c;
            color: white;
        }

        .btn-admin {
            background-color: transparent;
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .btn-admin:hover {
            background-color: rgba(211, 47, 47, 0.1);
            color: #D32F2F;
            border-color: #D32F2F;
        }
    </style>
</head>

<body>


    <div class="home-card">
        <div class="text-center mb-4">
            <img src="view/midia/logo.png" alt="Celestina Point" style="max-width: 200px; height: auto;">
        </div>

        <p class="mb-4 opacity-75">Selecione como deseja acessar:</p>

        <button type="button" class="btn-custom btn-cliente" data-bs-toggle="modal" data-bs-target="#modalCodigoMesa">
            <i class="ph ph-book-open me-2"></i> Iniciar para Cliente
        </button>

        <a href="index.php?page=login" class="btn-custom btn-admin">
            <i class="ph ph-lock-key me-2"></i> Área do Administrador
        </a>
    </div>

    <div class="modal fade" id="modalCodigoMesa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #D32F2F; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-password me-2"></i>Acessar Mesa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="index.php?controller=mesa&action=acessarCardapio" method="POST">
                    <div class="modal-body p-4 text-center">
                        <p class="text-muted mb-4">Peça ao garçom o <strong>Código de Acesso</strong> da sua mesa para iniciar o pedido.</p>
                        <input type="text" name="codigo" class="form-control form-control-lg text-center fw-bold" placeholder="EX: A7X9" required autocomplete="off" style="font-size: 1.5rem; text-transform: uppercase; letter-spacing: 3px;">
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4">
                        <button type="submit" class="btn btn-lg w-100 fw-bold" style="background-color: #D32F2F; color: white;">Entrar no Cardápio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
</body>

</html>