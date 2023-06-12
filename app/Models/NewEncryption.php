<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewEncryption extends Model
{
    protected $table = "new_encryption";
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'NIK',
        'phone_number',
        'user_id'
    ];
    
    protected $casts = [
        'date_of_birth' => 'date'
    ];
}
