<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'dep',
        'arrival',
        'start_point',
        'end_point',
        'driver_id',
        'costs',
    ];

    public function workdays()
{
    return $this->hasMany(Workday::class, 'driver_id', 'driver_id');
}


    public function getCostsAttribute()
    {
        return number_format($this->attributes['costs'], 2, ',', '.') ;
    }
}
