<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $table = 'genres';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'image',
        'genre_music'
    ];

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_genre', 'genre_id', 'location_id');
    }

    public function concerts()
    {
        return $this->belongsToMany(Concert::class, LocationGenre::class, 'location_genre', 'genre_id', 'concert_id');
    }
 
}
