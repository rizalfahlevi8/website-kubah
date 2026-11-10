<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_movements extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';

    protected $fillable = [
        'item_id',
        'jenis',
        'jumlah',
        'keterangan',
        'tanggal',
    ];

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }
}
