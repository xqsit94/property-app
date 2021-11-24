<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, BindsOnUuid, GeneratesUuid;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = "string";

    /**
     * The name of the column that should be used for the UUID.
     *
     * @return string
     */
    public function uuidColumn(): string
    {
        return "id";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["first_name", "last_name"];

    /**
     * The user phone numbers
     *
     * @return HasMany
     */
    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }
}
