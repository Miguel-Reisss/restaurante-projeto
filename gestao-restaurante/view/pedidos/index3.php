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
            transition: opacity 0.3s;
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
        }
    </style>
</head>

<body>

    <div class="header mb-4">
        <a href="index.php?page=home" class="btn btn-outline-light btn-sm"><i class="ph ph-arrow-left"></i> Sair do Painel</a>
        <h4 class="mb-0 fw-bold"><i class="ph ph-cooking-pot"></i> Gestão de Pedidos</h4>
        <div style="width: 100px;"></div>
    </div>

    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h5 class="fw-bold m-0">Pedidos Recentes</h5>
            <div class="d-flex align-items-center gap-3">
                <div class="form-check form-switch m-0 pt-1">
                    <input class="form-check-input" type="checkbox" id="toggleEntregues" style="cursor: pointer;">
                    <label class="form-check-label fw-bold text-muted small user-select-none" for="toggleEntregues" style="cursor: pointer;">
                        Ocultar Entregues
                    </label>
                </div>
                <button onclick="window.location.reload();" class="btn btn-primary btn-sm fw-bold">
                    <i class="ph ph-arrows-clockwise"></i> Atualizar
                </button>
            </div>
        </div>

        <div class="row g-4" id="lista-pedidos">
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

                    // Adiciona uma classe CSS especial APENAS nos pedidos finalizados
                    $classeFiltro = ($pedido['status'] === 'entregue') ? 'pedido-entregue' : '';

                    if ($pedido['status'] === 'aberto') {
                        $badgeClass = 'bg-danger';
                        $statusTexto = 'Novo Pedido';
                    } elseif ($pedido['status'] === 'preparando') {
                        $badgeClass = 'bg-warning text-dark';
                    } elseif ($pedido['status'] === 'pronto') {
                        $badgeClass = 'bg-success';
                    }
                    ?>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 <?= $classeFiltro ?>">
                        <div class="pedido-card">

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-0">Pedido #<?= $pedido['id'] ?></h5>
                                    <span class="text-muted small">Mesa: <?= htmlspecialchars($pedido['id_mesa']) ?></span>

                                    <?php
                                    $dataFormatada = isset($pedido['data_criacao']) ? date('d/m/Y \à\s H:i', strtotime($pedido['data_criacao'])) : 'Data indisponível';
                                    ?>
                                    <br>
                                    <span class="text-muted" style="font-size: 0.75rem;">
                                        <i class="ph ph-clock"></i> <?= $dataFormatada ?>
                                    </span>
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
                                        <option value="entregue" <?= $pedido['status'] == 'entregue' ? 'selected' : '' ?>>Entregue</option>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('toggleEntregues');
            const pedidosEntregues = document.querySelectorAll('.pedido-entregue');

            // 1. Verifica na memória se o Caixa já tinha deixado o botão marcado antes
            const ocultar = localStorage.getItem('ocultar_entregues_celestina') === 'true';
            toggle.checked = ocultar;

            // 2. Função que esconde ou mostra os cards com a classe .pedido-entregue
            function aplicarFiltro() {
                pedidosEntregues.forEach(pedido => {
                    pedido.style.display = toggle.checked ? 'none' : 'block';
                });

                // Salva a nova preferência na memória do navegador
                localStorage.setItem('ocultar_entregues_celestina', toggle.checked);
            }

            // 3. Quando o botão for clicado, aplica o filtro na hora!
            toggle.addEventListener('change', aplicarFiltro);

            // 4. Aplica o filtro assim que a tela abre
            aplicarFiltro();
        });
    </script>
</body>

</html>