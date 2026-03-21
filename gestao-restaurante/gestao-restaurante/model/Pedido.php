<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/conexao.php';

class Pedido
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::getConnection();
    }

    public function criar(array $dados): int
    {
        $sql = 'INSERT INTO pedidos (mesa_id, tipo, status, total, observacoes, data_criacao)
                VALUES (:mesa_id, :tipo, :status, :total, :observacoes, NOW())';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':mesa_id', $dados['mesa_id'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':tipo', $dados['tipo'] ?? 'salao');
        $stmt->bindValue(':status', $dados['status'] ?? 'aberto');
        $stmt->bindValue(':total', $dados['total'] ?? 0);
        $stmt->bindValue(':observacoes', $dados['observacoes'] ?? '');

        $stmt->execute();

        return (int) $this->conn->lastInsertId();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql  = 'SELECT * FROM pedidos WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $pedido = $stmt->fetch();

        return $pedido ?: null;
    }

    public function listar(?string $status = null, ?string $tipo = null): array
    {
        $sql    = 'SELECT * FROM pedidos WHERE 1=1';
        $params = [];

        if ($status !== null) {
            $sql              .= ' AND status = :status';
            $params['status'] = $status;
        }

        if ($tipo !== null) {
            $sql            .= ' AND tipo = :tipo';
            $params['tipo'] = $tipo;
        }

        $sql .= ' ORDER BY data_criacao DESC';

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function atualizar(int $id, array $dados): bool
    {
        $sql = 'UPDATE pedidos
                SET mesa_id = :mesa_id,
                    tipo = :tipo,
                    status = :status,
                    total = :total,
                    observacoes = :observacoes
                WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':mesa_id', $dados['mesa_id'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':tipo', $dados['tipo'] ?? 'salao');
        $stmt->bindValue(':status', $dados['status'] ?? 'aberto');
        $stmt->bindValue(':total', $dados['total'] ?? 0);
        $stmt->bindValue(':observacoes', $dados['observacoes'] ?? '');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $sql  = 'UPDATE pedidos SET status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deletar(int $id): bool
    {
        $sql  = 'DELETE FROM pedidos WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

