<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require dirname(__DIR__) . '/vendor/autoload.php';
$app = require dirname(__DIR__) . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$sourceConnectionName = DB::connection()->getDriverName() === 'mysql' ? config('database.default') : 'mysql_source';
if ($sourceConnectionName === 'mysql_source') {
    config(['database.connections.mysql_source' => [
        'driver' => 'mysql',
        'host' => env('MYSQL_SOURCE_HOST', '127.0.0.1'),
        'port' => env('MYSQL_SOURCE_PORT', '3306'),
        'database' => env('MYSQL_SOURCE_DATABASE', ''),
        'username' => env('MYSQL_SOURCE_USERNAME', ''),
        'password' => env('MYSQL_SOURCE_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
    ]]);
}

$targetUser = getenv('MSSQL_USERNAME') ?: '';
$targetPassword = getenv('MSSQL_PASSWORD') ?: '';
if ($targetUser === '' || $targetPassword === '') {
    fwrite(STDERR, "Set MSSQL_USERNAME and MSSQL_PASSWORD before running this script.\n");
    exit(1);
}

$target = new PDO(
    sprintf(
        'sqlsrv:Server=%s,%s;Database=%s;TrustServerCertificate=1',
        getenv('MSSQL_HOST') ?: 'localhost',
        getenv('MSSQL_PORT') ?: '1433',
        getenv('MSSQL_DATABASE') ?: 'erpgo_mssql'
    ),
    $targetUser,
    $targetPassword,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
$sourceConnection = DB::connection($sourceConnectionName);
$source = $sourceConnection->getPdo();
$sourceDatabase = $sourceConnection->getDatabaseName();

$statement = $source->prepare(
    "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
      WHERE TABLE_SCHEMA = ? AND TABLE_TYPE = 'BASE TABLE' ORDER BY TABLE_NAME"
);
$statement->execute([$sourceDatabase]);
$tables = $statement->fetchAll(PDO::FETCH_COLUMN);
$mismatches = [];

foreach ($tables as $table) {
    $mysqlTable = '`' . str_replace('`', '``', $table) . '`';
    $sqlServerTable = '[' . str_replace(']', ']]', $table) . ']';
    $sourceCount = (int) $source->query("SELECT COUNT(*) FROM {$mysqlTable}")->fetchColumn();
    $targetCount = (int) $target->query("SELECT COUNT(*) FROM {$sqlServerTable}")->fetchColumn();
    if ($sourceCount !== $targetCount) {
        $mismatches[] = "{$table}: {$sourceCount} != {$targetCount}";
    }
}

$aggregates = [
    ['revenues', 'amount'],
    ['payments', 'amount'],
    ['transactions', 'amount'],
    ['invoice_products', 'quantity'],
    ['invoice_products', 'price'],
    ['invoice_products', 'discount'],
    ['bill_products', 'quantity'],
    ['bill_products', 'price'],
    ['bill_products', 'discount'],
];

foreach ($aggregates as [$table, $column]) {
    $sourceValue = (string) $source->query("SELECT COALESCE(SUM(`{$column}`), 0) FROM `{$table}`")->fetchColumn();
    $targetValue = (string) $target->query("SELECT COALESCE(SUM([{$column}]), 0) FROM [{$table}]")->fetchColumn();
    if (bccomp($sourceValue, $targetValue, 4) !== 0) {
        $mismatches[] = "SUM({$table}.{$column}): {$sourceValue} != {$targetValue}";
    }
    printf("%-38s MySQL=%-16s MSSQL=%s\n", "SUM({$table}.{$column})", $sourceValue, $targetValue);
}

printf("Tables checked: %d; mismatches: %d\n", count($tables), count($mismatches));
foreach ($mismatches as $mismatch) {
    echo "MISMATCH {$mismatch}\n";
}

exit($mismatches === [] ? 0 : 2);
