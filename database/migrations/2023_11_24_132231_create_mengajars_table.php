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
        Schema::create('mengajar', function (Blueprint $table) {
            $table->string('id', 6);
            $table->string('id_detail_mata_pelajaran', 6);
            $table->string('id_guru', 6);

            $table->primary('id');
            $table->foreign('id_detail_mata_pelajaran')
            ->references('id')
            ->on('detail_mata_pelajaran')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('id_guru')
            ->references('id')
            ->on('guru')
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
        Schema::dropIfExists('mengajar');
    }
};
