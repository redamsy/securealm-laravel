<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegularUser extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function educationalCertificates(): BelongsToMany
    {
        return $this->belongsToMany(EducationalCertificate::class, 'ruecs', 'regular_user_id','educational_certificate_id', 'user_id', 'id');
    }
}
