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
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('group_st_id')->constrained('group_st')->cascadeOnDelete();
            $table->foreignId('ma_pegawai_id')->nullable()->constrained('ma_pegawai')->nullOnDelete();

            // Identitas Pegawai
            $table->string('nama');
            $table->string('nip');
            $table->string('pangkat');
            $table->string('jabatan');

            // Kwitansi
            $table->string('terima_kuitansi');           // "Pejabat Pembuat Komitmen ..."
            $table->string('no_kwitansi')->unique();
            $table->date('tanggal_kuitansi');

            // SPD
            $table->string('sppd')->unique();             // nomor SPD
            $table->date('tanggal_sppd');
            $table->text('tujuan_kegiatan');

            // Biaya DRPP
            $table->string('untuk_drpp')->nullable();
            $table->string('ruang')->nullable();
            $table->string('satker')->nullable();

            // Lokasi
            $table->string('asal_provinsi');
            $table->string('asal_daerah');
            $table->string('tujuan_provinsi');
            $table->string('tujuan_daerah');
            $table->string('nama_bandara_asal')->nullable();
            $table->string('nama_bandara_tujuan')->nullable();

            // Hari & Uang Harian
            $table->integer('jumlah_hari');
            $table->string('terbilang_hari');             // "6 Hari"
            $table->decimal('upah_harian', 15, 2);
            $table->decimal('jumlah_upah_harian', 15, 2);
            $table->decimal('uang_representatif', 15, 2)->default(0);
            $table->decimal('jumlah_uang_representatif', 15, 2);

            // Transportasi Lokal
            $table->decimal('taksi_bandara_provinsi|pusat', 15, 2)->default(0);
            $table->decimal('taksi_bandara_daerah', 15, 2)->default(0);
            $table->decimal('jumlah_transportasi', 15, 2);

            // Hotel
            $table->decimal('sbu_hotel', 15, 2)->nullable();
            $table->string('hari_penginapan_30')->nullable();     // "2 Hari"
            $table->decimal('jumlah_hari_penginapan_30', 15, 2)->default(0);
            $table->integer('jumlah_hari_penginapan');
            $table->decimal('harga_hotel', 15, 2);
            $table->decimal('jumlah_harga_hotel', 15, 2);

            // Tiket Pesawat
            $table->decimal('pesawat', 15, 2)->default(0);

            // Total
            $table->decimal('total', 15, 2);
            $table->decimal('drpp_awal', 15, 2)->nullable();
            $table->text('terbilang');

            // Detail Transport
            $table->string('angkutan')->nullable();
            $table->string('berangkat')->nullable();
            $table->string('tiba')->nullable();

            // Akun & Potongan
            $table->string('akun');
            $table->decimal('jumlah_sebelum_dipotong', 15, 2);
            $table->decimal('potong_kas', 15, 2)->default(0);
            $table->decimal('jumlah_setelah_dipotong', 15, 2);
            $table->decimal('jumlah_uang_hotel_tiket', 15, 2)->default(0);
            $table->decimal('jumlah_yang_diterima', 15, 2);

            // Audit
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
    }
};
