<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class LP extends Model
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description'
    ];

    public function artist()
    {
        return $this->belongsTo('App\Models\V1\Artist');
    }

    public function songs()
    {
        return $this->hasMany('App\Models\V1\Song');
    }
}
