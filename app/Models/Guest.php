<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'email',
        'address',
        'loyalty_points',
        'check_in_date',
        'check_out_date',
        'status'
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
}
