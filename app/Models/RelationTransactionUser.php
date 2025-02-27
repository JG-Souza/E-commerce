<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationTransactionUser extends Model
{
    protected $table = 'relation_transaction_users';

    protected $fillable = ['transactions_id', 'users_id', 'role'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
