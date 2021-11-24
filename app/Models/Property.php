<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    /**
     * The property address
     *
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Property Owners and main owner
     *
     * @return BelongsToMany
     */
    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "owners")->withPivot(
            "main_owner"
        );
    }
}
