<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasShortflakePrimary;

class Place extends Model
{
    use HasShortflakePrimary, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'open',
        'postalCode'
    ];

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }
}
