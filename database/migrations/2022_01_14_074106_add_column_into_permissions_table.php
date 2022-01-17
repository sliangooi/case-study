<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoPermissionsTable extends Migration
{
    protected $table = 'permissions';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->unsignedBigInteger('module_id')->after('id');
            $table->string('action')->after('module_id');
            $table->string('display_name')->after('name');
            $table->foreign('module_id')->references('id')->on('modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropIndex('permissions_module_id_foreign');
            $table->dropColumn('module_id');
            $table->dropColumn('action');
            $table->dropColumn('display_name');
        });
    }
}
