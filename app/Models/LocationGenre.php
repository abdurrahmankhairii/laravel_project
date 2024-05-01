<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationGenre extends Model
{
    use HasFactory;

    protected $table = 'location_genre';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function location()
    {
        return $this->belongsToMany(Location::class, 'location_id');
    }

    public function genre()
    {
        return $this->belongsToMany(Genre::class, 'genre_id');
    }

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

}
