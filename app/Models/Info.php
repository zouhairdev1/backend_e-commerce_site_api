<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory,Sluggable;
    protected $fillable = [
        'first_name',
        'last_name',
        'slug_user',
        'tele',
        'cin',
        'city',
        'country',
        'adresse',
        'role_id',
        'user_id',
        'email',
        'password',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    public function sluggable(): array
    {
        return [
            'slug_user' => [
                'source' => 'first_name'
            ]
        ];
    }
}
