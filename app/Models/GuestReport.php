<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'guest_name',
        'relationship',
        'visit_date',
        'visit_time',
        'duration',
        'purpose',
        'guest_phone',
        'status',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'recorded' => 'Tercatat',
            'acknowledged' => 'Dikonfirmasi Pengelola',
            default => ucfirst($this->status),
        };
    }
}
