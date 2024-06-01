<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reset_token'
    ];

    // relationships
    public function user(){
        return $this->belongsTo(User::class);
    }
}
