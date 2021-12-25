<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Authenticatable
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'driver';
    protected $primaryKey = 'driver_id';
}
