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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('kd_kelas');
            $table->string('nama_kelas');
            $table->string('nip');
            $table->string('nim');
            $table->unsignedBigInteger('kd_matkul');
            $table->foreign('nip')->references('nip')->on('dosen')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kd_matkul')->references('kd_matkul')->on('matakuliah')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas');
    }
};
