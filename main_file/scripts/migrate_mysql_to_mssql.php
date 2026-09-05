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

$targetHost = getenv('MSSQL_HOST') ?: 'localhost';
$targetPort = getenv('MSSQL_PORT') ?: '1433';
$targetDatabase = getenv('MSSQL_DATABASE') ?: 'erpgo_mssql';
$targetUser = getenv('MSSQL_USERNAME') ?: '';
$targetPassword = getenv('MSSQL_PASSWORD') ?: '';

if ($targetUser === '' || $targetPassword === '') {
    fwrite(STDERR, "Set MSSQL_USERNAME and MSSQL_PASSWORD before running this script.\n");
    exit(1);
}

$target = new PDO(
    "sqlsrv:Server={$targetHost},{$targetPort};Database={$targetDatabase};TrustServerCertificate=1",
    $targetUser,
    $targetPassword,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$sourceConnection = DB::connection($sourceConnectionName);
$source = $sourceConnection->getPdo();
$sourceDatabase = $sourceConnection->getDatabaseName();

$sourceTablesStatement = $source->prepare(
    "SELECT TABLE_NAME
       FROM INFORMATION_SCHEMA.TABLES
      WHERE TABLE_SCHEMA = ?
        AND TABLE_TYPE = 'BASE TABLE'
      ORDER BY TABLE_NAME"
);
$sourceTablesStatement->execute([$sourceDatabase]);
$sourceTables = $sourceTablesStatement->fetchAll(PDO::FETCH_COLUMN);

$targetTables = $target->query(
    "SELECT TABLE_NAME
       FROM INFORMATION_SCHEMA.TABLES
      WHERE TABLE_SCHEMA = 'dbo'
        AND TABLE_TYPE = 'BASE TABLE'"
)->fetchAll(PDO::FETCH_COLUMN);
$targetTableLookup = array_fill_keys($targetTables, true);

$quoteSqlServerIdentifier = static function (string $identifier): string {
    return '[' . str_replace(']', ']]', $identifier) . ']';
};

$target->exec("EXEC sp_MSforeachtable 'ALTER TABLE ? NOCHECK CONSTRAINT ALL'");

$results = [];

try {
    foreach ($sourceTables as $table) {
        if (!isset($targetTableLookup[$table])) {
            $results[] = [$table, 'SKIPPED', 0, 0, 'Target table is missing'];
            continue;
        }

        $sourceColumnsStatement = $source->prepare(
            "SELECT COLUMN_NAME
               FROM INFORMATION_SCHEMA.COLUMNS
              WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
              ORDER BY ORDINAL_POSITION"
        );
        $sourceColumnsStatement->execute([$sourceDatabase, $table]);
        $sourceColumns = $sourceColumnsStatement->fetchAll(PDO::FETCH_COLUMN);

        $targetColumnsStatement = $target->prepare(
            "SELECT COLUMN_NAME
               FROM INFORMATION_SCHEMA.COLUMNS
              WHERE TABLE_SCHEMA = 'dbo' AND TABLE_NAME = ?
              ORDER BY ORDINAL_POSITION"
        );
        $targetColumnsStatement->execute([$table]);
        $targetColumns = $targetColumnsStatement->fetchAll(PDO::FETCH_COLUMN);
        $targetColumnLookup = array_fill_keys($targetColumns, true);
        $columns = array_values(array_filter(
            $sourceColumns,
            static fn (string $column): bool => isset($targetColumnLookup[$column])
        ));

        if ($columns === []) {
            $results[] = [$table, 'SKIPPED', 0, 0, 'No common columns'];
            continue;
        }

        $quotedTable = $quoteSqlServerIdentifier($table);
        $target->exec("DELETE FROM {$quotedTable}");

        $identityStatement = $target->prepare(
            "SELECT COUNT(*)
               FROM sys.identity_columns
              WHERE object_id = OBJECT_ID(?)"
        );
        $identityStatement->execute([$table]);
        $hasIdentity = (int) $identityStatement->fetchColumn() > 0;

        if ($hasIdentity) {
            $target->exec("SET IDENTITY_INSERT {$quotedTable} ON");
        }

        $mysqlColumnList = implode(', ', array_map(
            static fn (string $column): string => '`' . str_replace('`', '``', $column) . '`',
            $columns
        ));
        $sqlServerColumnList = implode(', ', array_map($quoteSqlServerIdentifier, $columns));
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));

        $read = $source->query("SELECT {$mysqlColumnList} FROM `{$table}`");
        $write = $target->prepare(
            "INSERT INTO {$quotedTable} ({$sqlServerColumnList}) VALUES ({$placeholders})"
        );

        $copied = 0;
        while ($row = $read->fetch(PDO::FETCH_ASSOC)) {
            foreach ($row as &$value) {
                if (is_string($value) && preg_match('/^0000-00-00(?: 00:00:00)?$/', $value)) {
                    $value = null;
                }
            }
            unset($value);

            $write->execute(array_values($row));
            $copied++;
        }

        if ($hasIdentity) {
            $target->exec("SET IDENTITY_INSERT {$quotedTable} OFF");
            $target->exec("DBCC CHECKIDENT ({$quotedTable}, RESEED)");
        }

        $sourceCount = (int) $source->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
        $targetCount = (int) $target->query("SELECT COUNT(*) FROM {$quotedTable}")->fetchColumn();
        $status = $sourceCount === $targetCount ? 'MATCH' : 'MISMATCH';
        $results[] = [$table, $status, $sourceCount, $targetCount, ''];
    }
} finally {
    $target->exec("EXEC sp_MSforeachtable 'ALTER TABLE ? WITH CHECK CHECK CONSTRAINT ALL'");
}

$mismatches = 0;
foreach ($results as [$table, $status, $sourceCount, $targetCount, $note]) {
    printf("%-40s %-9s %8d %8d %s\n", $table, $status, $sourceCount, $targetCount, $note);
    if ($status !== 'MATCH') {
        $mismatches++;
    }
}

printf(
    "\nCompared %d source tables; %d table(s) require attention.\n",
    count($results),
    $mismatches
);

exit($mismatches === 0 ? 0 : 2);
