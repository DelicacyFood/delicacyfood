<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
    protected $table = 'driver';
    protected $primaryKey = 'driver_id';
}
