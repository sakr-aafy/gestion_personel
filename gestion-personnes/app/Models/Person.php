<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'ville',
        'date_naissance'
    ];

    protected $casts = [
        'date_naissance' => 'date'
    ];
}