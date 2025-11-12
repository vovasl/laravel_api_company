<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'edrpou',
        'address',
        'version',
    ];

    /**
     * @return HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(CompanyVersion::class);
    }
}
