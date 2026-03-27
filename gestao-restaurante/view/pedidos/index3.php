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

        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3 flex-wrap gap-3">
            <h5 class="fw-bold m-0">Pedidos Recentes</h5>

            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <span class="input-group-text bg-white"><i class="ph ph-magnifying-glass"></i></span>
                    <input type="text" id="pesquisaPedido" class="form-control" placeholder="Buscar Pedido...">
                </div>

                <div class="form-check form-switch m-0 pt-1">
                    <input class="form-check-input" type="checkbox" id="toggleEntregues" style="cursor: pointer;">
                    <label class="form-check-label fw-bold text-muted small user-select-none" for="toggleEntregues" style="cursor: pointer;">
                        Ocultar Entregues
                    </label>
                </div>

                <button onclick="window.location.reload();" class="btn btn-primary btn-sm fw-bold">
                    <i class="ph ph-arrows-clockwise"></i> Atualizar
                </button>
                
                <button type="button" class="btn btn-dark btn-sm fw-bold ms-2" data-bs-toggle="modal" data-bs-target="#modalCodigosGarcom">
                    <i class="ph ph-password"></i> Códigos das Mesas
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

                    // Marca os entregues para o filtro funcionar
                    $classeFiltro = ($pedido['status'] === 'entregue') ? 'pedido-entregue' : '';

                    if ($pedido['status'] === 'aberto') {
                        $badgeClass = 'bg-danger';
                        $statusTexto = 'Novo Pedido';
                    } elseif ($pedido['status'] === 'preparando') {
                        $badgeClass = 'bg-warning text-dark';
                    } elseif ($pedido['status'] === 'pronto') {
                        $badgeClass = 'bg-success';
                    }

                    $dataFormatada = isset($pedido['data_criacao']) ? date('d/m/Y \à\s H:i', strtotime($pedido['data_criacao'])) : 'Data indisponível';
                    ?>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 pedido-wrapper <?= $classeFiltro ?>">
                        <div class="pedido-card">

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-0 titulo-pedido">Pedido #<?= $pedido['id'] ?></h5>
<span class="text-muted small">Mesa: <?= htmlspecialchars($pedido['numero_da_mesa'] ?? $pedido['id_mesa']) ?></span>                                    <br>
                                    <span class="text-muted" style="font-size: 0.75rem;">
                                        <i class="ph ph-clock"></i> <?= $dataFormatada ?>
                                    </span>
                                </div>
                                <span class="badge status-badge <?= $badgeClass ?>"><?= $statusTexto ?></span>
                            </div>

                            <h6 class="fw-bold text-success">Total: R$ <?= number_format($pedido['total'], 2, ',', '.') ?></h6>

                            <div class="observacoes-box my-3">
                                <strong class="text-dark">Itens do Pedido:</strong><br>
                                <span style="font-size: 0.95rem;"><?= nl2br(htmlspecialchars($pedido['itens_resumo'] ?? '')) ?></span>

                                <?php if (!empty(trim($pedido['observacoes'] ?? ''))): ?>
                                    <hr style="margin: 8px 0; border-color: #ccc;">
                                    <strong class="text-danger">Obs:</strong> <?= htmlspecialchars($pedido['observacoes']) ?>
                                <?php endif; ?>
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

    <div class="modal fade" id="modalCodigosGarcom" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #2B2D42; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-password me-2"></i>Códigos de Acesso das Mesas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Mesa</th>
                                <th>Status</th>
                                <th>Código (PIN)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mesas)): ?>
                                <?php foreach ($mesas as $m): ?>
                                    <tr>
                                        <td class="fw-bold fs-5 text-dark">Mesa <?= htmlspecialchars($m['numero']) ?></td>
                                        <td><?= $m['status'] == 'livre' ? '<span class="badge bg-success">Livre</span>' : '<span class="badge bg-danger">Ocupada</span>' ?></td>
                                        <td>
                                            <span class="badge bg-dark fs-5 py-2 px-3" style="letter-spacing: 3px;">
                                                <?= htmlspecialchars($m['codigo_acesso'] ?? '---') ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-muted py-4">Nenhuma mesa cadastrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('toggleEntregues');
            const search = document.getElementById('pesquisaPedido');
            const cards = document.querySelectorAll('.pedido-wrapper');

            // Puxa a preferência do switch na memória
            const ocultar = localStorage.getItem('ocultar_entregues_celestina') === 'true';
            toggle.checked = ocultar;

            function aplicarFiltros() {
                const esconder = toggle.checked;
                // Pega o que foi digitado, joga pra minúsculo e tira o "#" se a pessoa digitar
                const termo = search.value.toLowerCase().replace('#', '').trim();

                cards.forEach(card => {
                    const isEntregue = card.classList.contains('pedido-entregue');
                    const titulo = card.querySelector('.titulo-pedido').innerText.toLowerCase();

                    let mostrar = true;

                    // Regra 1: Ocultar Entregues
                    if (esconder && isEntregue) mostrar = false;

                    // Regra 2: Pesquisa por Número
                    if (termo !== '' && !titulo.includes(termo)) mostrar = false;

                    card.style.display = mostrar ? 'block' : 'none';
                });

                localStorage.setItem('ocultar_entregues_celestina', esconder);
            }

            // Dispara quando clica no switch ou quando digita na barra
            toggle.addEventListener('change', aplicarFiltros);
            search.addEventListener('input', aplicarFiltros);

            aplicarFiltros();
        });
    </script>
</body>

</html>