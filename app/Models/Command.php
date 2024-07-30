<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_FAILED = 'failed';
    protected $fillable = ['status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lineCommands()
    {
        return $this->hasMany(Line_commands::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
