<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Colunas. Preciso entender melhor o HasFactory
    protected $fillable = [
        'name', 'unit_price', 'quantity', 'description', 'category', 'img_path'
    ];
}
