<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saved_item extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','product_id'];
}
