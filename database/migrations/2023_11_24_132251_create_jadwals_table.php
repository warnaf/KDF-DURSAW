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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->string('id_mengajar');
            $table->integer('waktu', false, true);
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->string('kelas_id', 6);

            $table->foreign('id_mengajar')
            ->references('id')
            ->on('mengajar')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('kelas_id')
            ->references('id')
            ->on('kelas')
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
        Schema::dropIfExists('jadwal');
    }
};
