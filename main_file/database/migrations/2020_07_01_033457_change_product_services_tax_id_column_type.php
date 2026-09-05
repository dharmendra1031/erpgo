<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeProductServicesTaxIdColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() === 'sqlsrv') {
            // Doctrine DBAL 2 cannot reliably discover SQL Server's generated
            // default-constraint name when changing an existing column.
            $constraints = DB::select("
                SELECT dc.name
                FROM sys.default_constraints dc
                INNER JOIN sys.columns c
                    ON c.object_id = dc.parent_object_id
                   AND c.column_id = dc.parent_column_id
                WHERE dc.parent_object_id = OBJECT_ID('product_services')
                  AND c.name = 'tax_id'
            ");

            foreach ($constraints as $constraint) {
                DB::statement(
                    'ALTER TABLE [product_services] DROP CONSTRAINT [' .
                    str_replace(']', ']]', $constraint->name) . ']'
                );
            }

            DB::statement(
                'ALTER TABLE [product_services] ALTER COLUMN [tax_id] NVARCHAR(50) NULL'
            );
        } else {
            Schema::table(
                'product_services', function (Blueprint $table){
                $table->string('tax_id', 50)->nullable()->change();
            }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'product_services', function (Blueprint $table){
            $table->dropColumn('tax_id');
        }
        );
    }
}
