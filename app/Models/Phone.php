<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    /*
     * Phone number types
     *
     * @var string[]
     */
    const PHONE_TYPE = [
        "MOBILE" => "mobile",
        "HOME" => "home",
        "WORK" => "work",
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["number", "type"];
}
