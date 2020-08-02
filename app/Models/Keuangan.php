<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'transaksi';
    public $primaryKey = 'id_trans';

    protected $fillable = [
        'tanggal', 'uraian', 'pemasukan', 'pengeluaran', 'seksi', 'keterangan'
    ];
}
