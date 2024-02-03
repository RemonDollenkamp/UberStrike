<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workday extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'driver_id',
        'day_of_the_week',
        'shift_start',
        'shift_end',
        'break-time',
        'status'
    ];
}
