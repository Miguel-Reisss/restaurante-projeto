<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Celestina Point</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Variáveis do Tema */
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: sans-serif;
            transition: background-color 0.3s, color 0.3s;
            margin: 0;
            position: relative;
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

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Ajuste dos inputs pro tema escuro */
        .form-control,
        .input-group-text {
            background-color: var(--bg-color);
            color: var(--text-color);
            border-color: var(--border-color);
        }

        .form-control:focus {
            background-color: var(--bg-color);
            color: var(--text-color);
            border-color: #D32F2F;
            /* Cor vermelha da Celestina Point */
            box-shadow: none;
        }

        .btn-primary-custom {
            background-color: #D32F2F;
            /* Cor do botão combinar com a logo */
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            font-weight: 500;
            width: 100%;
            color: #fff;
            margin-top: 1rem;
            transition: 0.3s;
        }

        .btn-primary-custom:hover {
            background-color: #b71c1c;
            color: #fff;
        }
    </style>
</head>

<body>

   

    <div class="login-card">

        <div class="text-center mb-4">
            <img src="view/midia/logo2.png" alt="Celestina Point" style="max-width: 180px; height: auto;">
        </div>

        <form action="index.php?controller=funcionarios&action=login" method="POST">

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuário</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ph ph-user"></i></span>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite seu usuário" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ph ph-lock-key"></i></span>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Sua senha" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom d-flex align-items-center justify-content-center">
                Entrar no Sistema <i class="ph ph-sign-in ms-2 fs-5"></i>
            </button>
            <a href="index.php?page=home" class="d-block text-center mt-3 text-muted text-decoration-none">← Voltar</a>
        </form>
    </div>

   
</body>

</html>