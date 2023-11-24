<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_mata_pelajaran', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->string('id', 6);
            $table->string('mata_pelajaran_ref', 6);
            $table->integer('jumlah_jam', false, true)->default(1);
            $table->integer('max_jam', false, true)->default(2);
            $table->integer('semester', false, true)->default(1);
            $table->enum('jenjang', ['7', '8', '9', '10', '11', '12']);

            $table->primary('id');
            $table->foreign('mata_pelajaran_ref')
            ->references('id')
            ->on('mata_pelajaran')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_mata_pelajaran');
    }
};
