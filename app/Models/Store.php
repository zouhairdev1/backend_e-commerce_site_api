<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = ['name','user_id'];
    public function user()
    {
        return $this->belongsTo(Info::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
