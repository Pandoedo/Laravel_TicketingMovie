<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSoftDeletesTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**1# ini kode membuat tambahan kolom  */
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes('deleted_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**2# ini kode untuk rollback tambahan kolom dan kelanjutan pada model user*/
        Schema::create('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');

        });
    }
    
}
