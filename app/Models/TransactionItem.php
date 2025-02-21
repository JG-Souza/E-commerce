<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    // Definindo explicitamente o nome da tabela
    protected $table = 'transactions_items';

    // Desabilitar timestamps
    public $timestamps = false;

    protected $fillable = [
        'quantity',
        'total_value',
        'products_id',
        'transactions_id'
    ];

    // Relacionamento com Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    // Relacionamento com Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id');
    }
}

