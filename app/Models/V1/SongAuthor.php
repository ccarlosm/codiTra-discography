<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class SongAuthor extends BaseModel
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'song_id',
        'author_id',
    ];

    public function song()
    {
        return $this->belongsTo('App\Models\V1\Song');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\V1\Author');
    }
}
