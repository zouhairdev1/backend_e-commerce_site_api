<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['store_id', 'category_id', 'name', 'description', 'price'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function linecommands()
    {
        return $this->hasMany(Line_commands::class);
    }

    public function usersSaved()
    {
        return $this->belongsToMany(User::class, 'saved');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
