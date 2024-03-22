<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Song extends BaseModel
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    public function LP()
    {
        return $this->belongsTo('App\Models\V1\LP');
    }

    //Relationship many to many through pivot table SongAuthor
    public function authors()
    {
        return $this->belongsToMany('App\Models\V1\Author', 'song_authors', 'song_id', 'author_id');
    }
}
