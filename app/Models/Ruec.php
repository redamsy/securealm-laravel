<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruec extends Model
{
    use HasFactory;

    protected $fillable = [
        'educational_certificate_id',
        'regular_user_id',
    ];
}
