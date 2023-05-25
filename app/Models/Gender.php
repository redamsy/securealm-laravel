<?php

namespace App\Models;
use App\Enums\GenderEnum;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => GenderEnum::class,
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
