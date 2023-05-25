<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EducationalCertificate extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    public function regularUsers(): BelongsToMany
    {
        return $this->belongsToMany(RegularUser::class, 'ruecs', 'educational_certificate_id','regular_user_id', 'id', 'user_id');
    }
}
