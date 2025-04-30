<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'group_id',
        'is_active'
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
