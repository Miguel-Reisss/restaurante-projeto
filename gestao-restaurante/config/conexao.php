<?php

declare(strict_types=1);

class Conexao
{
   
    private static $host = "10.91.45.61";
    private static $usuario = "admin";
    private static $senha = "123456";

    // O nome EXATO como está na sua base de dados agora (sem espaços à volta!)
    private static $banco = "gestao_restaurante";

    private static $charset = "utf8mb4";

    public static function getConnection(): PDO
    {
        static $pdo = null;

        if ($pdo instanceof PDO) {
            return $pdo;
        }

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            self::$host,
            self::$banco,
            self::$charset
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, self::$usuario, self::$senha, $options);
        } catch (PDOException $e) {
            die('Erro fatal de Conexão: ' . $e->getMessage());
        }

        return $pdo;
    }
}
