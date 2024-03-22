<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Author extends BaseModel
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];

    //Relationship many to many through pivot table SongAuthor
    public function songs()
    {
        return $this->belongsToMany('App\Models\V1\Song', 'song_author', 'author_id', 'song_id');
    }
}
