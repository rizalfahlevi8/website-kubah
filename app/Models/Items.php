<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'kode',
        'nama',
        'satuan',
        'stock',
    ];

    public function stockMovements()
    {
        return $this->hasMany(stock_movements::class, 'item_id');
    }
}
