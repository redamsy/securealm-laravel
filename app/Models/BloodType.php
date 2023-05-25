<?php

namespace App\Models;
use App\Models\User;
use App\Enums\BloodTypeEnum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => BloodTypeEnum::class,
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
