<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailtransaksiModel extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    protected $primarykey = 'id';
    public $timestamps = false;
    public $fillable = [
        'id_transaksi','id_menu','qty','harga'
    ];
}
