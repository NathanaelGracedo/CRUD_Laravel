<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksiModel extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primarykey = 'id';
    public $timestamps = false;
    public $fillable = [
        'tgl_transaksi','id_user','id_meja','nama_pelanggan','status'
    ];
}
