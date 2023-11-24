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
        Schema::create('guru', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->string('id', 6);
            $table->string('nama_guru', 30);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('department_id', 6);
            $table->enum('jabatan', ['Principal',
            'Counselor',
            'School_Coordinator',
            'Homeroom',
            'Head_of_department',
            'Science_Lab_Coordinator',
            'Lab_Assistant']);
            $table->date('tanggal_masuk');

            $table->primary('id');
            $table->foreign('department_id')
            ->references('id')
            ->on('departments')
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
        Schema::dropIfExists('guru');
    }
};
