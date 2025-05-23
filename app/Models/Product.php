<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'unit_price', 'quantity', 'description', 'category', 'img_path', 'users_id'
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'users_id');
}

}
