<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { background-color: #F8F9FA; font-family: sans-serif; }
        .sidebar { height: 100vh; background-color: #2B2D42; color: white; padding-top: 20px; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 15px 20px; display: block; font-weight: 500; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #1e1f2e; color: white; border-left: 4px solid #D32F2F; }
        .sidebar .logo { font-size: 1.5rem; font-weight: bold; padding: 0 20px 20px 20px; border-bottom: 1px solid #3f425c; margin-bottom: 20px; color: white; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar d-none d-md-block">
            <div class="logo"><i class="ph ph-storefront"></i> Gestão</div>
            <a href="index.php?controller=pedido&action=index" class="active"><i class="ph ph-receipt"></i> Pedidos Ativos</a>
            <a href="index.php?controller=produto&action=index"><i class="ph ph-hamburger"></i> Produtos</a>
            <a href="#"><i class="ph ph-list"></i> Categorias</a>
            <a href="#"><i class="ph ph-users"></i> Funcionários</a>
            <a href="#"><i class="ph ph-armchair"></i> Mesas</a>
            <a href="index.php?page=home" class="mt-5 text-danger"><i class="ph ph-sign-out"></i> Sair do Painel</a>
        </div>

        <div class="col-md-10 p-4">
            <h2 class="fw-bold mb-4">Visão Geral</h2>
            <p class="text-muted">Selecione uma opção no menu ao lado para gerir o sistema.</p>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0 bg-primary text-white">
                        <div class="card-body py-4 text-center">
                            <h5 class="card-title"><i class="ph ph-receipt fs-1"></i></h5>
                            <p class="card-text mb-0 fw-bold">Gestão de Pedidos</p>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>

</body>
</html>