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
        'created_by',
    ];

    /**
     * Get the user that owns the deposit
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    /**
     * Get the user creator
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
