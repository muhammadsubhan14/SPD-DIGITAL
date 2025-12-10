<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaPegawai extends Model
{
    use HasFactory;

    protected $table = 'ma_pegawai'; 

    protected $fillable = [
        'nama',
        'nip',
        'gol',
        'jabatan',
        'satker',
        'asal',
        'tujuan',
        'bandara',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    //biar lebih rapi saat dipanggil
    public function getNamaLengkapAttribute()
    {
        return $this->nama . ' (' . $this->nip . ')';
    }

    // Scope buat cari cepat (nanti dipakai di autocomplete)
    public function scopeSearch($query, $keyword)
    {
        return $query->where('nip', 'LIKE', "%{$keyword}%")
            ->orWhere('nama', 'LIKE', "%{$keyword}%");
    }

    // Scope hanya yang aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
