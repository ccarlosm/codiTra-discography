<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Artist extends BaseModel
{
    use HasApiTokens, HasFactory;

    protected $table = 'artists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function LPs()
    {
        return $this->hasMany('App\Models\V1\LP');
    }
}
