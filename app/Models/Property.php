<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $appends = ['main_owner', 'sub_owners'];

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

    /**
     * Fetches main owner
     *
     * @return mixed|null
     */
    public function getMainOwnerAttribute()
    {
        return $this->owners()->with('phones')->where('main_owner', true)->first();
    }

    public function getSubOwnersAttribute()
    {
        return $this->owners()->where('main_owner', false)->get();
    }
}
