<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['user_id'];
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'user_id';
}
