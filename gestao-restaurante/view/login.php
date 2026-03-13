<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabor &amp; Tempo | Login</title>
    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #e25724;
            --bg: #d8d8d8ff;
            --bg-soft: #111827;
            --card-bg: #020617;
            --text: #ff6b35;
            --muted: #9ca3af;
            --success: #22c55e;
            --danger: #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: white;
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: conic-gradient(from 180deg, #ffb703, #fb8500, #ff6b35, #f97316, #ffb703);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: #111827;
            font-weight: 800;
            font-size: 26px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        }

        .brand-title {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .brand-subtitle {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.98), rgba(15, 23, 42, 0.9));
            border-radius: 18px;
            padding: 24px 22px 20px;
            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.7),
                0 0 0 1px rgba(148, 163, 184, 0.15);
            backdrop-filter: blur(14px);
        }

        .card-header {
            margin-bottom: 18px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-subtitle {
            font-size: 0.82rem;
            color: var(--muted);
            margin-top: 4px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 10px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #e5e7eb;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input,
        .input-wrapper select {
            width: 100%;
            padding: 10px 11px 10px 34px;
            border-radius: 10px;
            border: 1px solid rgba(55, 65, 81, 0.9);
            background: rgba(15, 23, 42, 0.85);
            color: var(--text);
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .input-wrapper select {
            padding-left: 10px;
            appearance: none;
        }

        .input-wrapper input::placeholder {
            color: #6b7280;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8rem;
            color: #6b7280;
            pointer-events: none;
        }

        .input-wrapper input:focus,
        .input-wrapper select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 1px rgba(249, 115, 22, 0.5);
            background: rgba(15, 23, 42, 0.95);
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2px;
            margin-bottom: 4px;
        }

        .meta-left {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: var(--muted);
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: var(--success);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.25);
        }

        .btn-primary {
            margin-top: 4px;
            width: 100%;
            border: none;
            border-radius: 999px;
            padding: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #111827;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow:
                0 12px 25px rgba(248, 113, 113, 0.35),
                0 0 0 1px rgba(148, 163, 184, 0.3);
            transition: transform 0.12s ease, box-shadow 0.12s ease, filter 0.12s ease;
        }

        .btn-primary span {
            font-size: 0.8rem;
        }

        .btn-primary:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
            box-shadow:
                0 16px 30px rgba(248, 113, 113, 0.45),
                0 0 0 1px rgba(248, 250, 252, 0.15);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow:
                0 8px 16px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(248, 250, 252, 0.12);
        }

        .helper {
            margin-top: 10px;
            text-align: center;
            font-size: 0.78rem;
            color: var(--muted);
        }

        .helper strong {
            color: #e5e7eb;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 0.75rem;
            color: #6b7280;
        }

        .footer span {
            color: #f97316;
            font-weight: 600;
        }

        @media (min-width: 768px) {
            .card {
                padding: 26px 26px 22px;
            }

            .card-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="brand">
        <div class="brand-logo">ST</div>
        <div class="brand-title">Sabor &amp; Tempo</div>
        <div class="brand-subtitle">Gestão ágil para salão e balcão</div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Acesse seu painel</div>
            <div class="card-subtitle">Garçom, Cozinha e Administração em um só lugar.</div>
        </div>

        <form method="post" action="/index.php?controller=login&action=autenticar">
            <div class="field">
                <label for="nivel_acesso">Perfil de acesso</label>
                <div class="input-wrapper">
                    <select id="nivel_acesso" name="nivel_acesso" required>
                        <option value="">Selecione...</option>
                        <option value="admin">Administração</option>
                        <option value="garcom">Garçom / Salão</option>
                        <option value="cozinha">Cozinha</option>
                        <option value="balcao">Balcão</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label for="usuario">Usuário</label>
                <div class="input-wrapper">
                    <span class="input-icon">@</span>
                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        placeholder="seu.usuario"
                        autocomplete="username"
                        required
                    >
                </div>
            </div>

            <div class="field">
                <label for="senha">Senha</label>
                <div class="input-wrapper">
                    <span class="input-icon">•••</span>
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                        minlength="4"
                    >
                </div>
            </div>

            <div class="meta-row">
                <div class="meta-left">
                    <span class="status-dot"></span>
                    <span>Servidor online</span>
                </div>
                <div class="meta-right" style="font-size: 0.78rem; color: var(--muted);">
                    Turno atual: <strong>Noite</strong>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <span>Entrar no SaborTech</span>
            </button>
        </form>

        <div class="helper">
            Acesso recomendado via <strong>tablet</strong> ou <strong>smartphone</strong> para garçons.
        </div>
    </div>

    <div class="footer">
        SaborTech &middot; <span>Sabor &amp; Tempo</span> &mdash; experiência moderna para o seu restaurante
    </div>
</div>
</body>
</html>

