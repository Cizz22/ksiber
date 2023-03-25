<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;

class MedicalRecord extends Model
{
    use HasFactory, EncryptableDbAttribute;

    protected $fillable = [
        'user_id',
        'date',
        'diagnosis',
        'prescription',
        'notes',
    ];

    protected $encryptable = [
        'date',
        'diagnosis',
        'prescription',
        'notes',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
