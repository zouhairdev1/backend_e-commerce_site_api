<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line_commands extends Model
{
    use HasFactory;
    protected $fillable = ['command_id','product_id','product_id','price'];
    public function command()
    {
        return $this->belongsTo(Command::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
