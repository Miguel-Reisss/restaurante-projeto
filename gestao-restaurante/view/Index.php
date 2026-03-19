<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Pedidos - Celestina Point</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        /* Variáveis de Cores - Tema Claro */
        :root {
            --bg-body: #F8F9FA;
            --text-main: #2B2D42;
            --sidebar-bg: #2B2D42;
            --sidebar-text: #ffffff;
            --sidebar-hover: #D32F2F;
            /* Pode mudar para o laranja da sua logo: #FF7800 */
            --card-bg: #ffffff;
            --border-color: #dee2e6;
            --table-header: #f8f9fa;
            --obs-bg: #f8f9fa;
        }

        /* Variáveis de Cores - Tema Escuro */
        

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Menu Lateral */
        .sidebar {
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            min-height: 100vh;
            padding: 20px;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            border-right: 1px solid var(--border-color);
            transition: background-color 0.3s;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            padding-top: 10px;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--sidebar-hover);
            color: white;
        }

        /* Cartão e Tabela */
        .card-custom {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s, border-color 0.3s;
        }

        .table {
            color: var(--text-main);
            --bs-table-bg: transparent;
            margin-bottom: 0;
        }

        .table-custom th {
            background-color: var(--table-header) !important;
            color: var(--text-main);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
        }

        .table-custom td {
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .form-select {
            background-color: var(--bg-body);
            color: var(--text-main);
            border-color: var(--border-color);
        }

        .form-select:focus {
            background-color: var(--bg-body);
            color: var(--text-main);
            border-color: #D32F2F;
            box-shadow: none;
        }

        .badge-aberto {
            background-color: #ffc107;
            color: #856404;
        }

        .badge-preparando {
            background-color: #17a2b8;
            color: #fff;
        }

        .badge-pronto {
            background-color: #28a745;
            color: #fff;
        }

        .badge-entregue {
            background-color: #6c757d;
            color: #fff;
        }

        .obs-box {
            background-color: var(--obs-bg);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 6px;
            padding: 8px;
            font-size: 0.9rem;
            max-height: 100px;
            overflow-y: auto;
            white-space: pre-wrap;
        }

        .btn-theme {
            color: var(--text-main);
            border-color: var(--border-color);
        }

        .btn-theme:hover {
            background-color: var(--obs-bg);
            color: var(--text-main);
        }
    </style>
</head>

<body>

    <div class="row g-0">
        <div class="col-md-2 sidebar d-none d-md-block">
            <div class="sidebar-brand">
                <img src="view/midia/logo.png" alt="Celestina Point" style="max-width: 140px; height: auto;">
            </div>

            <a href="index.php?controller=pedido&action=index" class="active"><i class="ph ph-receipt fs-5 me-2"></i> Pedidos Ativos</a>
            <a href="#"><i class="ph ph-armchair fs-5 me-2"></i> Mesas</a>
            <a href="index.php?controller=produto&action=index"><i class="ph ph-hamburger fs-5 me-2"></i> Produtos</a>
            <a href="index.php?page=home" class="text-danger mt-5" style="border: 1px solid #dc3545;"><i class="ph ph-sign-out fs-5 me-2"></i> Sair</a>
        </div>

        <div class="col-md-10 p-4 pb-5 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold m-0">Gestão de Pedidos</h2>

                <div class="d-flex gap-2">
                   
                        <i class="ph ph-moon"></i>
                    </button>

                    <a href="index.php?controller=pedido&action=index" class="btn" style="background-color: #D32F2F; color: white;">
                        <i class="ph ph-arrows-clockwise me-1"></i> Atualizar
                    </a>
                </div>
            </div>

            <div class="card card-custom">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nº Pedido</th>
                                    <th>Mesa</th>
                                    <th style="width: 30%;">Itens Selecionados</th>
                                    <th>Total</th>
                                    <th>Status Atual</th>
                                    <th class="pe-4 text-center">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pedidos)): ?>
                                    <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold">#<?= str_pad((string)$pedido['id'], 4, '0', STR_PAD_LEFT) ?></td>

                                            <td>
                                                <span class="badge bg-dark fs-6">
                                                    Mesa <?= htmlspecialchars((string)$pedido['mesa_id']) ?>
                                                </span>
                                            </td>

                                            <td>
                                                <div class="obs-box"><?= htmlspecialchars($pedido['observacoes']) ?></div>
                                            </td>

                                            <td class="fw-bold text-success" style="color: #28a745 !important;">
                                                R$ <?= number_format((float)$pedido['total'], 2, ',', '.') ?>
                                            </td>

                                            <td>
                                                <span class="badge badge-<?= strtolower($pedido['status']) ?> px-3 py-2">
                                                    <?= ucfirst($pedido['status']) ?>
                                                </span>
                                            </td>

                                            <td class="pe-4">
                                                <form action="index.php?controller=pedido&action=atualizarStatus&id=<?= $pedido['id'] ?>" method="POST" class="d-flex gap-2 justify-content-center">
                                                    <select name="status" class="form-select form-select-sm" style="width: 130px;">
                                                        <option value="aberto" <?= $pedido['status'] == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                                                        <option value="preparando" <?= $pedido['status'] == 'preparando' ? 'selected' : '' ?>>Preparando</option>
                                                        <option value="pronto" <?= $pedido['status'] == 'pronto' ? 'selected' : '' ?>>Pronto</option>
                                                        <option value="entregue" <?= $pedido['status'] == 'entregue' ? 'selected' : '' ?>>Entregue</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary" title="Salvar Status">
                                                        <i class="ph ph-check"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="ph ph-receipt fs-1 d-block mb-2 opacity-50"></i>
                                            Nenhum pedido ativo no momento.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>

</html>