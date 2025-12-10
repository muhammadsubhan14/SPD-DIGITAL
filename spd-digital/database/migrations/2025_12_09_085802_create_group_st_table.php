<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_st', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_st')->unique();
            $table->date('tanggal_st');
            $table->text('tujuan_kegiatan');
            $table->string('provinsi');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_pulang');
            $table->string('akun');
            $table->string('ppk_nama');
            $table->string('ppk_nip');
            $table->string('ppk_jabatan');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_st');
    }
};
