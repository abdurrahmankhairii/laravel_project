<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city', 'image',
    ];

        /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
    ];

      /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be nullable.
     *
     * @var array
     */
    protected $nullable = [
        'image',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'location_genre', 'location_id', 'genre_id');
    }

    // public function concerts()
    // {
    //     return $this->hasManyThrough(Concert::class, 'location_genre', 'location_id', 'concert_id');
    // }
}
