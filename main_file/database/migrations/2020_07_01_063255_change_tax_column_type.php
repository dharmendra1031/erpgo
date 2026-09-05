<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeTaxColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() === 'sqlsrv') {
            foreach (['proposal_products', 'invoice_products', 'bill_products'] as $table) {
                $constraints = DB::select("
                    SELECT dc.name
                    FROM sys.default_constraints dc
                    INNER JOIN sys.columns c
                        ON c.object_id = dc.parent_object_id
                       AND c.column_id = dc.parent_column_id
                    WHERE dc.parent_object_id = OBJECT_ID(?)
                      AND c.name = 'tax'
                ", [$table]);

                foreach ($constraints as $constraint) {
                    DB::statement(
                        'ALTER TABLE [' . $table . '] DROP CONSTRAINT [' .
                        str_replace(']', ']]', $constraint->name) . ']'
                    );
                }

                DB::statement(
                    'ALTER TABLE [' . $table . '] ALTER COLUMN [tax] NVARCHAR(50) NULL'
                );
            }

            return;
        }

        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->string('tax', '50')->nullable()->change();
        }
        );
        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->string('tax', '50')->nullable()->change();
        }
        );
        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->string('tax', '50')->nullable()->change();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->dropColumn('tax');
        }
        );
        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->dropColumn('tax');
        }
        );
        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->dropColumn('tax');
        }
        );
    }
}
