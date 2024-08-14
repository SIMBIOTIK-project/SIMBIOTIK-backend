<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'id_user',
        'price',
        'status',
    ];

    /**
     * Get the user that owns the deposit
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
