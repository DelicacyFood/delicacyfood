<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Users as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'users';
    protected $primaryKey = 'user_id';
}
