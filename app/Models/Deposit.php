<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_wastetype',
        'weight',
        'price',
        'created_by',
    ];

    /**
     * Get the user that owns the deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Get the wastype that owns the deposit.
     */
    public function wastetype()
    {
        return $this->belongsTo(Wastetype::class, 'id_wastetype', 'id');
    }

    /**
     * Get the user creator
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
