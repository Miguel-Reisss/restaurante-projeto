<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Pedidos - Celestina Point</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <meta http-equiv="refresh" content="30">

    <style>
        :root {
            --bg-color: #F8F9FA;
            --text-color: #2B2D42;
            --card-bg: #ffffff;
            --header-bg: #2B2D42;
            /* Cor diferente para diferenciar que é a área Admin */
            --header-text: #ffffff;
            --border-color: #dee2e6;
        }

      

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: sans-serif;
            padding-bottom: 50px;
        }

        .header {
            background-color: var(--header-bg);
            color: var(--header-text);
            padding: 15px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pedido-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
        }

        .observacoes-box {
            background-color: var(--bg-color);
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            padding: 10px;
            font-size: 0.95rem;
            flex-grow: 1;
            white-space: pre-wrap;
            /* Mantém as quebras de linha do texto */
        }

        .btn-theme {
            background: transparent;
            border: none;
            color: var(--header-text);
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="header mb-4">
        <a href="index.php?page=home" class="btn btn-outline-light btn-sm"><i class="ph ph-arrow-left"></i> Sair do Painel</a>
        <h4 class="mb-0 fw-bold"><i class="ph ph-cooking-pot"></i> Gestão de Pedidos</h4>
       
    </div>

    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold">Pedidos Recentes</h5>
            <button onclick="window.location.reload();" class="btn btn-primary btn-sm"><i class="ph ph-arrows-clockwise"></i> Atualizar Agora</button>
        </div>

        <div class="row g-4">
            <?php if (empty($pedidos)): ?>
                <div class="col-12 text-center py-5">
                    <i class="ph ph-clipboard-text" style="font-size: 4rem; color: var(--border-color);"></i>
                    <h5 class="mt-3 text-muted">Nenhum pedido no momento.</h5>
                </div>
            <?php else: ?>

                <?php foreach ($pedidos as $pedido): ?>

                    <?php
                    $badgeClass = 'bg-secondary';
                    $statusTexto = ucfirst($pedido['status']);

                    if ($pedido['status'] === 'aberto') {
                        $badgeClass = 'bg-danger';
                        $statusTexto = 'Novo Pedido';
                    } elseif ($pedido['status'] === 'preparando') {
                        $badgeClass = 'bg-warning text-dark';
                    } elseif ($pedido['status'] === 'pronto') {
                        $badgeClass = 'bg-success';
                    }
                    ?>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="pedido-card">

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-0">Pedido #<?= $pedido['id'] ?></h5>
                                    <span class="text-muted small">Mesa: <?= htmlspecialchars($pedido['mesa_id']) ?></span>
                                </div>
                                <span class="badge status-badge <?= $badgeClass ?>"><?= $statusTexto ?></span>
                            </div>

                            <h6 class="fw-bold text-success">Total: R$ <?= number_format($pedido['total'], 2, ',', '.') ?></h6>

                            <div class="observacoes-box my-3">
                                <?= htmlspecialchars($pedido['observacoes']) ?>
                            </div>

                            <div class="mt-auto border-top pt-3" style="border-color: var(--border-color) !important;">
                                <form action="index.php?controller=pedido&action=atualizarStatus&id=<?= $pedido['id'] ?>" method="POST" class="d-flex gap-2">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="aberto" <?= $pedido['status'] == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                                        <option value="preparando" <?= $pedido['status'] == 'preparando' ? 'selected' : '' ?>>Preparando</option>
                                        <option value="pronto" <?= $pedido['status'] == 'pronto' ? 'selected' : '' ?>>Pronto</option>
                                        <option value="entregue" <?= $pedido['status'] == 'entregue' ? 'selected' : '' ?>>Finalizado</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-dark">Salvar</button>
                                </form>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

  
</body>

</html>