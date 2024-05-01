<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concert extends Model
{
    use HasFactory;

    protected $table = 'concerts';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    protected $fillable = [
        'image',
        'concert_name',
        'description',
        'location_id',
        'genre_id',
        'price',
        'seat',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function orders()
    {
        return $this->hasOne(Order::class);
    }
}
