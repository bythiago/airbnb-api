<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_type',
        'room_type',
        'total_occupancy',
        'total_bedrooms',
        'total_bathrooms',
        'summary',
        'address',
        'has_tv',
        'has_kitchen',
        'has_air_con',
        'has_heating',
        'has_internet',
        'price',
        'published_at',
        'owner_id',
        'latitude',
        'longitude',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function reservations()
    {
        return $this->belongsToMany(User::class, 'reservations')
            ->withTimestamps()
            ->withPivot(['start_date', 'end_date', 'price', 'total']);
    }
}
