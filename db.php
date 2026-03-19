<?php
declare(strict_types=1);

function loadEnv(string $path): array {
    if (!is_file($path)) throw new RuntimeException("Missing .env at: $path");
    $env = [];
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        [$k, $v] = array_pad(explode('=', $line, 2), 2, '');
        $env[trim($k)] = trim($v);
    }
    return $env;
}

$env = loadEnv(__DIR__ . '/.env');

$host = $env['DB_HOST'] ?? 'localhost';
$port = $env['DB_PORT'] ?? '5432';
$db   = $env['DB_NAME'] ?? 'postgres';
$user = $env['DB_USER'] ?? 'postgres';
$pass = $env['DB_PASS'] ?? '';

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";

$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

return $pdo;