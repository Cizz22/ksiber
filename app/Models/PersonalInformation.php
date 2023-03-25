<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;

class PersonalInformation extends Model
{
    use HasFactory, EncryptableDbAttribute;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'NIK',
        'phone_number',
        'user_id'
    ];


    protected $encryptable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'NIK',
        'phone_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
