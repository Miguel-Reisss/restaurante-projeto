<?php

declare(strict_types=1);

class Conexao
{
    private const DB_HOST = '10.91.45.61';
    private const DB_NAME = 'gestao-restaurante';
    private const DB_USER = 'admin';
    private const DB_PASS = '123456';
    private const DB_CHARSET = 'utf8mb4';
    

    /**
     * Retorna uma instância única de PDO (Singleton simples).
     *
     * @throws Exception Se não for possível conectar ao banco.
     */
    public static function getConnection(): PDO
    {
        static $pdo = null;

        if ($pdo instanceof PDO) {
            return $pdo;
        }

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            self::DB_HOST,
            self::DB_NAME,
            self::DB_CHARSET
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
        } catch (PDOException $e) {
            // Loga o erro técnico e lança exceção genérica para o usuário final.
            error_log('[DB ERROR] ' . $e->getMessage());
            throw new Exception('Erro ao conectar ao banco de dados. Tente novamente mais tarde.');
        }

        return $pdo;
    }
}

