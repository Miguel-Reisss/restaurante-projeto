<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel CEO - Celestina Point</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { background-color: #F8F9FA; font-family: sans-serif; overflow-x: hidden; }
        .sidebar { background-color: #2B2D42; min-height: 100vh; color: white; padding-top: 20px; }
        .sidebar .nav-link { color: #adb5bd; margin-bottom: 5px; border-radius: 8px; font-weight: 500; }
        .sidebar .nav-link.active { background-color: #D32F2F; color: white; }
        .sidebar .nav-link:hover:not(.active) { background-color: rgba(255, 255, 255, 0.1); }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); }
        .logo-area { font-size: 1.5rem; font-weight: bold; border-bottom: 1px solid #3f425c; padding-bottom: 20px; margin-bottom: 20px; text-align: center; }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">

            <div class="col-md-2 sidebar p-3">
                <div class="logo-area"><i class="ph ph-crown text-warning"></i> Painel CEO</div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-resumo" type="button"><i class="ph ph-squares-four"></i> Visão Geral</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-produtos" type="button"><i class="ph ph-hamburger"></i> Produtos</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-categorias" type="button"><i class="ph ph-list-dashes"></i> Categorias</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-mesas" type="button"><i class="ph ph-armchair"></i> Mesas</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-funcionarios" type="button"><i class="ph ph-users"></i> Funcionários</button>
                </div>

                <div class="mt-5 px-3">
                    <button type="button" class="btn btn-outline-light w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalVerPedidos">
                        <i class="ph ph-receipt"></i> Ver Pedidos
                    </button>
                </div>
            </div>

            <div class="col-md-10 p-5 bg-light">
                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="tab-resumo">
                        <h2 class="fw-bold mb-4">Bem-vindo CEO!</h2>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-primary text-white">
                                    <h1 class="fw-bold"><?= count($produtos) ?></h1><span>Produtos Ativos</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-success text-white">
                                    <h1 class="fw-bold"><?= count($mesas) ?></h1><span>Mesas</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-warning text-dark">
                                    <h1 class="fw-bold"><?= count($categorias) ?></h1><span>Categorias</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-danger text-white">
                                    <h1 class="fw-bold"><?= count($funcionarios) ?></h1><span>Funcionários</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-produtos">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold m-0">Gestão de Produtos</h3>
                            <button type="button" class="btn fw-bold" style="background-color: #D32F2F; color: white;" data-bs-toggle="modal" data-bs-target="#modalNovoProduto"><i class="ph ph-plus-circle"></i> Cadastrar Produto</button>
                        </div>
                        <div class="card card-custom p-0 overflow-hidden">
                            <table class="table table-hover bg-white align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Nome do Produto</th>
                                        <th>Categoria</th>
                                        <th>Preço</th>
                                        <th class="text-center pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtos as $p): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?= htmlspecialchars($p['nome']) ?></td>
                                            <td><span class="badge bg-secondary"><?= htmlspecialchars($p['categoria_nome'] ?? 'Sem Categoria') ?></span></td>
                                            <td class="text-success fw-bold"><?= !empty($p['tem_tamanhos']) ? 'Múltiplos Tamanhos' : 'R$ ' . number_format((float)$p['preco'], 2, ',', '.') ?></td>
                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-outline-primary btn-edit-produto"
                                                        data-id="<?= $p['id'] ?>" data-nome="<?= htmlspecialchars($p['nome']) ?>"
                                                        data-cat="<?= $p['categoria_id'] ?>" data-preco="<?= $p['preco'] ?>"
                                                        data-tamanhos="<?= $p['tem_tamanhos'] ?>" data-precop="<?= $p['preco_p'] ?>"
                                                        data-precom="<?= $p['preco_m'] ?>" data-precog="<?= $p['preco_g'] ?>"
                                                        data-desc="<?= htmlspecialchars($p['descricao']) ?>"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarProduto" title="Editar">
                                                        <i class="ph ph-pencil-simple"></i>
                                                    </button>
                                                    <a href="index.php?controller=produto&action=deletar&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Excluir este produto?')"><i class="ph ph-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-categorias">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold m-0">Gestão de Categorias</h3>
                            <button type="button" class="btn fw-bold" style="background-color: #D32F2F; color: white;" data-bs-toggle="modal" data-bs-target="#modalNovaCategoria"><i class="ph ph-plus-circle"></i> Nova Categoria</button>
                        </div>
                        <div class="card card-custom p-0 overflow-hidden">
                            <table class="table table-hover bg-white align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Nome da Categoria</th>
                                        <th class="text-center pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categorias as $cat): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?= htmlspecialchars($cat['nome']) ?></td>
                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-outline-primary btn-edit-categoria"
                                                        data-id="<?= $cat['id'] ?>" data-nome="<?= htmlspecialchars($cat['nome']) ?>"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarCategoria" title="Editar">
                                                        <i class="ph ph-pencil-simple"></i>
                                                    </button>
                                                    <?php if (!in_array($cat['id'], [1, 2, 3])): ?>
                                                        <a href="index.php?controller=categoria&action=deletar&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir esta categoria?')"><i class="ph ph-trash"></i></a>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary mt-1">Fixo</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-mesas">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold m-0">Gestão de Mesas</h3>
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=admin&action=index" class="btn fw-bold btn-outline-primary"><i class="ph ph-arrows-clockwise"></i> Atualizar Status</a>
                                <button type="button" class="btn fw-bold" style="background-color: #D32F2F; color: white;" data-bs-toggle="modal" data-bs-target="#modalNovaMesa"><i class="ph ph-plus-circle"></i> Nova Mesa</button>
                            </div>
                        </div>
                        <div class="card card-custom p-0 overflow-hidden">
                            <table class="table table-hover bg-white align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Mesa</th>
                                        <th>Lugares</th>
                                        <th>Código de Acesso</th> <th>Status</th>
                                        <th class="text-center pe-4">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mesas as $m): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold fs-5">Mesa <?= $m['numero'] ?></td>
                                            <td><?= $m['capacidade'] ?> Lugares</td>
                                            
                                            <td>
                                                <span class="badge bg-dark fs-6" style="letter-spacing: 2px;">
                                                    <?= htmlspecialchars($m['codigo_acesso'] ?? 'GERAR') ?>
                                                </span>
                                            </td>

                                            <td><?= $m['status'] == 'livre' ? '<span class="badge bg-success">Livre</span>' : '<span class="badge bg-danger">Ocupada</span>' ?></td>
                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <?php if ($m['status'] == 'ocupada'): ?>
                                                        <a href="index.php?controller=mesa&action=liberar&id=<?= $m['id'] ?>" class="btn btn-sm btn-warning fw-bold text-dark">Liberar</a>
                                                    <?php endif; ?>
                                                    <a href="index.php?controller=mesa&action=deletar&id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apagar esta mesa?')"><i class="ph ph-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-funcionarios">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold m-0">Equipe e Funcionários</h3>
                            <button type="button" class="btn fw-bold" style="background-color: #D32F2F; color: white;" data-bs-toggle="modal" data-bs-target="#modalNovoFuncionario"><i class="ph ph-plus-circle"></i> Novo Funcionário</button>
                        </div>
                        <div class="card card-custom p-0 overflow-hidden">
                            <table class="table table-hover bg-white align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Nome e E-mail</th>
                                        <th>Nível de Acesso</th>
                                        <th class="text-center pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($funcionarios as $f): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?= htmlspecialchars($f['nome']) ?><br><small class="text-muted fw-normal"><?= htmlspecialchars($f['email']) ?></small></td>
                                            <td><span class="badge bg-dark"><?= strtoupper($f['nivel_acesso']) ?></span></td>
                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-outline-primary btn-edit-funcionario"
                                                        data-id="<?= $f['id'] ?>" data-nome="<?= htmlspecialchars($f['nome']) ?>"
                                                        data-email="<?= htmlspecialchars($f['email']) ?>" data-nivel="<?= $f['nivel_acesso'] ?>"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarFuncionario" title="Editar">
                                                        <i class="ph ph-pencil-simple"></i>
                                                    </button>
                                                    <?php if ($f['id'] != 1): ?>
                                                        <a href="index.php?controller=funcionarios&action=delete&id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover o acesso?')"><i class="ph ph-trash"></i></a>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger mt-1">CEO</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVerPedidos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #2B2D42; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-receipt me-2"></i>Andamento dos Pedidos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">

                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <span class="input-group-text bg-white"><i class="ph ph-magnifying-glass"></i></span>
                            <input type="text" id="pesquisaPedidoCEO" class="form-control" placeholder="Buscar Pedido...">
                        </div>

                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" id="toggleEntreguesCEO" style="cursor: pointer;">
                            <label class="form-check-label fw-bold text-muted small user-select-none" for="toggleEntreguesCEO" style="cursor: pointer;">
                                Ocultar Entregues
                            </label>
                        </div>
                    </div>

                    <div class="row g-3">
                        <?php if (empty($pedidos)): ?>
                            <div class="col-12 text-center py-5">
                                <i class="ph ph-clipboard-text text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">Nenhum pedido no momento.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($pedidos as $pedido): ?>
                                <?php
                                $badgeClass = 'bg-secondary';
                                if ($pedido['status'] === 'aberto') $badgeClass = 'bg-danger';
                                elseif ($pedido['status'] === 'preparando') $badgeClass = 'bg-warning text-dark';
                                elseif ($pedido['status'] === 'pronto') $badgeClass = 'bg-success';

                                $dataFormatada = isset($pedido['data_criacao']) ? date('d/m/Y \à\s H:i', strtotime($pedido['data_criacao'])) : '';

                                // Classe para identificar os entregues
                                $classeFiltroCEO = ($pedido['status'] === 'entregue') ? 'pedido-entregue-ceo' : '';
                                ?>

                                <div class="col-md-6 col-lg-4 pedido-wrapper-ceo <?= $classeFiltroCEO ?>">
                                    <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="fw-bold mb-0 titulo-pedido-ceo">Pedido #<?= $pedido['id'] ?></h6>
                                                    <small class="text-muted">Mesa <?= htmlspecialchars($pedido['id_mesa']) ?></small>
                                                </div>
                                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($pedido['status']) ?></span>
                                            </div>

                                            <div class="mb-3 flex-grow-1" style="font-size: 0.85rem; max-height: 90px; overflow-y: auto; background: #f8f9fa; padding: 8px; border-radius: 6px; border: 1px dashed #dee2e6;">
                                                <strong class="text-dark">Itens:</strong><br>
                                                <?= nl2br(htmlspecialchars($pedido['itens_resumo'] ?? '')) ?>

                                                <?php if (!empty(trim($pedido['observacoes'] ?? ''))): ?>
                                                    <div class="mt-2 text-danger">
                                                        <strong>Obs:</strong> <?= htmlspecialchars($pedido['observacoes']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-end mt-auto border-top pt-2">
                                                <span class="text-success fw-bold">R$ <?= number_format($pedido['total'], 2, ',', '.') ?></span>
                                                <small class="text-muted" style="font-size: 0.75rem;"><i class="ph ph-clock"></i> <?= $dataFormatada ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovoProduto" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #2B2D42; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-hamburger me-2"></i>Novo Produto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="index.php?controller=produto&action=store" method="POST" enctype="multipart/form-data">
                        <div class="mb-3"><label class="form-label fw-bold small">Nome do Produto *</label><input type="text" name="nome" class="form-control" required></div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Categoria *</label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($categorias as $cat): ?><option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option><?php endforeach; ?>
                            </select>
                        </div>
                        <div class="border p-3 mb-3 rounded bg-light">
                            <label class="form-label fw-bold small text-primary">Preço Único</label>
                            <div class="input-group mb-2"><span class="input-group-text">R$</span><input type="text" name="preco" class="form-control"></div>
                            <hr class="my-3 border-secondary">
                            <label class="form-check-label mb-2 fw-bold text-danger"><input type="checkbox" name="tem_tamanhos" value="1" class="form-check-input me-1"> Ativar tamanhos (P, M, G)</label>
                            <div class="row g-2">
                                <div class="col-4"><input type="text" name="preco_p" class="form-control form-control-sm text-center" placeholder="Valor P"></div>
                                <div class="col-4"><input type="text" name="preco_m" class="form-control form-control-sm text-center" placeholder="Valor M"></div>
                                <div class="col-4"><input type="text" name="preco_g" class="form-control form-control-sm text-center" placeholder="Valor G"></div>
                            </div>
                        </div>
                        <div class="mb-3"><label class="form-label fw-bold small">Descrição (Opcional)</label><textarea name="descricao" class="form-control" rows="2"></textarea></div>
                        <div class="mb-4"><label class="form-label fw-bold small">Foto do Produto</label><input type="file" name="imagem" class="form-control form-control-sm"></div>
                        <button class="btn btn-lg w-100 fw-bold" style="background-color: #D32F2F; color: white;">Salvar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarProduto" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #004085; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-pencil-simple me-2"></i>Editar Produto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="index.php?controller=produto&action=update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="edit_prod_id">
                        <div class="mb-3"><label class="form-label fw-bold small">Nome do Produto *</label><input type="text" name="nome" id="edit_prod_nome" class="form-control" required></div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Categoria *</label>
                            <select name="categoria_id" id="edit_prod_categoria" class="form-select" required>
                                <?php foreach ($categorias as $cat): ?><option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option><?php endforeach; ?>
                            </select>
                        </div>
                        <div class="border p-3 mb-3 rounded bg-light">
                            <label class="form-label fw-bold small text-primary">Preço Único</label>
                            <div class="input-group mb-2"><span class="input-group-text">R$</span><input type="text" name="preco" id="edit_prod_preco" class="form-control"></div>
                            <hr class="my-3 border-secondary">
                            <label class="form-check-label mb-2 fw-bold text-danger"><input type="checkbox" name="tem_tamanhos" id="edit_prod_tem_tamanhos" value="1" class="form-check-input me-1"> Ativar tamanhos</label>
                            <div class="row g-2">
                                <div class="col-4"><input type="text" name="preco_p" id="edit_prod_preco_p" class="form-control form-control-sm text-center" placeholder="Valor P"></div>
                                <div class="col-4"><input type="text" name="preco_m" id="edit_prod_preco_m" class="form-control form-control-sm text-center" placeholder="Valor M"></div>
                                <div class="col-4"><input type="text" name="preco_g" id="edit_prod_preco_g" class="form-control form-control-sm text-center" placeholder="Valor G"></div>
                            </div>
                        </div>
                        <div class="mb-3"><label class="form-label fw-bold small">Descrição</label><textarea name="descricao" id="edit_prod_desc" class="form-control" rows="2"></textarea></div>
                        <div class="mb-4"><label class="form-label fw-bold small">Nova Foto (Opcional)</label><input type="file" name="imagem" class="form-control form-control-sm"></div>
                        <button class="btn btn-lg w-100 fw-bold" style="background-color: #004085; color: white;">Atualizar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovaCategoria" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #2B2D42; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-list-dashes me-2"></i>Nova Categoria</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="index.php?controller=categoria&action=store" method="POST">
                        <div class="mb-4"><label class="form-label fw-bold small">Nome *</label><input type="text" name="nome" class="form-control" required></div><button class="btn btn-lg w-100 fw-bold" style="background-color: #D32F2F; color: white;">Adicionar Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCategoria" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #004085; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-pencil-simple me-2"></i>Editar Categoria</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="index.php?controller=categoria&action=update" method="POST"><input type="hidden" name="id" id="edit_cat_id">
                        <div class="mb-4"><label class="form-label fw-bold small">Nome *</label><input type="text" name="nome" id="edit_cat_nome" class="form-control" required></div><button class="btn btn-lg w-100 fw-bold" style="background-color: #004085; color: white;">Atualizar Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovaMesa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #2B2D42; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-armchair me-2"></i>Nova Mesa</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="index.php?controller=mesa&action=store" method="POST">
                        <div class="mb-3"><label class="form-label fw-bold small">Número *</label><input type="number" name="numero" class="form-control" required></div>
                        <div class="mb-4"><label class="form-label fw-bold small">Capacidade *</label><input type="number" name="capacidade" class="form-control" required></div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Código de Acesso (Deixe vazio para gerar sozinho)</label>
                            <input type="text" name="codigo_acesso" class="form-control text-uppercase" maxlength="10" placeholder="EX: A7X9">
                        </div>

                        <button class="btn btn-lg w-100 fw-bold" style="background-color: #D32F2F; color: white;">Adicionar Mesa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovoFuncionario" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #2B2D42; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-users me-2"></i>Novo Funcionário</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="index.php?controller=funcionarios&action=store" method="POST" autocomplete="off">
                        <div class="mb-3"><label class="form-label fw-bold small">Nome *</label><input type="text" name="nome" class="form-control" required autocomplete="off"></div>
                        <div class="mb-3"><label class="form-label fw-bold small">E-mail *</label><input type="text" name="email" class="form-control" required autocomplete="off"></div>
                        <div class="mb-3"><label class="form-label fw-bold small">Senha *</label><input type="password" name="senha" class="form-control" required autocomplete="new-password"></div>
                        <div class="mb-4"><label class="form-label fw-bold small">Nível *</label><select name="nivel_acesso" class="form-select">
                                <option value="garcom">Garçom</option>
                                <option value="caixa">Caixa</option>
                                <option value="admin">Administrador</option>
                            </select></div><button class="btn btn-lg w-100 fw-bold" style="background-color: #D32F2F; color: white;">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarFuncionario" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #004085; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="ph ph-pencil-simple me-2"></i>Editar Funcionário</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formEditarFuncionario" method="POST" autocomplete="off"><input type="hidden" name="ativo" value="1">
                        <div class="mb-3"><label class="form-label fw-bold small">Nome *</label><input type="text" name="nome" id="edit_func_nome" class="form-control" required autocomplete="off"></div>
                        <div class="mb-3"><label class="form-label fw-bold small">E-mail *</label><input type="text" name="email" id="edit_func_email" class="form-control" required autocomplete="off"></div>
                        <div class="mb-3"><label class="form-label fw-bold small">Nova Senha (Opcional)</label><input type="password" name="senha" class="form-control" placeholder="Deixe em branco para manter a atual" autocomplete="new-password"></div>
                        <div class="mb-4"><label class="form-label fw-bold small">Nível *</label><select name="nivel_acesso" id="edit_func_nivel" class="form-select">
                                <option value="garcom">Garçom</option>
                                <option value="caixa">Caixa</option>
                                <option value="admin">Administrador</option>
                            </select></div><button class="btn btn-lg w-100 fw-bold" style="background-color: #004085; color: white;">Atualizar Acesso</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // 1. Memória das Abas
            let abaSalva = localStorage.getItem('aba_ativa_ceo');
            if (abaSalva) {
                let botaoAba = document.querySelector('button[data-bs-target="' + abaSalva + '"]');
                if (botaoAba) {
                    new bootstrap.Tab(botaoAba).show();
                }
            }
            document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(function(botao) {
                botao.addEventListener('shown.bs.tab', function(event) {
                    localStorage.setItem('aba_ativa_ceo', event.target.getAttribute('data-bs-target'));
                });
            });

            // 2. Preencher Modal: Editar Produto
            document.querySelectorAll('.btn-edit-produto').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('edit_prod_id').value = this.dataset.id;
                    document.getElementById('edit_prod_nome').value = this.dataset.nome;
                    document.getElementById('edit_prod_categoria').value = this.dataset.cat;
                    document.getElementById('edit_prod_preco').value = this.dataset.preco;
                    document.getElementById('edit_prod_desc').value = this.dataset.desc;
                    document.getElementById('edit_prod_tem_tamanhos').checked = (this.dataset.tamanhos == '1');
                    document.getElementById('edit_prod_preco_p').value = this.dataset.precop;
                    document.getElementById('edit_prod_preco_m').value = this.dataset.precom;
                    document.getElementById('edit_prod_preco_g').value = this.dataset.precog;
                });
            });

            // 3. Preencher Modal: Editar Categoria
            document.querySelectorAll('.btn-edit-categoria').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('edit_cat_id').value = this.dataset.id;
                    document.getElementById('edit_cat_nome').value = this.dataset.nome;
                });
            });

            // 4. Preencher Modal: Editar Funcionario
            document.querySelectorAll('.btn-edit-funcionario').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    document.getElementById('formEditarFuncionario').action = 'index.php?controller=funcionarios&action=update&id=' + id;
                    document.getElementById('edit_func_nome').value = this.dataset.nome;
                    document.getElementById('edit_func_email').value = this.dataset.email;
                    document.getElementById('edit_func_nivel').value = this.dataset.nivel;
                });
            });

            // 5. Filtro e Pesquisa do Modal de Pedidos do CEO
            const toggleCEO = document.getElementById('toggleEntreguesCEO');
            const searchCEO = document.getElementById('pesquisaPedidoCEO');
            const cardsCEO = document.querySelectorAll('.pedido-wrapper-ceo');

            if (toggleCEO && searchCEO) {
                const ocultarCEO = localStorage.getItem('ocultar_entregues_ceo') === 'true';
                toggleCEO.checked = ocultarCEO;

                function aplicarFiltrosCEO() {
                    const esconder = toggleCEO.checked;
                    const termo = searchCEO.value.toLowerCase().replace('#', '').trim();

                    cardsCEO.forEach(card => {
                        const isEntregue = card.classList.contains('pedido-entregue-ceo');
                        const titulo = card.querySelector('.titulo-pedido-ceo').innerText.toLowerCase();

                        let mostrar = true;
                        if (esconder && isEntregue) mostrar = false;
                        if (termo !== '' && !titulo.includes(termo)) mostrar = false;

                        card.style.display = mostrar ? 'block' : 'none';
                    });
                    localStorage.setItem('ocultar_entregues_ceo', esconder);
                }

                toggleCEO.addEventListener('change', aplicarFiltrosCEO);
                searchCEO.addEventListener('input', aplicarFiltrosCEO);

                // Dispara o filtro assim que abre a janela
                document.getElementById('modalVerPedidos').addEventListener('shown.bs.modal', aplicarFiltrosCEO);
            }

        });
    </script>
</body>

</html>