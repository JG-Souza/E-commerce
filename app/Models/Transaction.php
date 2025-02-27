<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_value',
        'status'
    ];

    // Relacionamento com TransactionItem
    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transactions_id');
    }

    // Relacionamento com User
    public function users()
    {
        return $this->belongsToMany(User::class, 'relation_transaction_users', 'transactions_id', 'users_id');
    }

    public function sellers()
    {
        return $this->hasMany(RelationTransactionUser::class, 'transactions_id')
                    ->where('role', 'seller');
    }
}

