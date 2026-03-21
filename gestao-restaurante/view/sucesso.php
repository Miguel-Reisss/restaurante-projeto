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
        <a href="index.php?page=home" class="btn btn-lg w-100" style="background-color: #D32F2F; color: white; border-radius: 8px; font-weight: bold;">
            Fazer Novo Pedido
        </a>
    </div>
</body>

</html>