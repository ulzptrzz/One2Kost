<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'facility_name',
        'description',
        'photo',
        'status',
        'admin_response',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if (!empty($this->photo)) {
            if (str_starts_with($this->photo, 'http')) {
                return $this->photo;
            }
            return asset($this->photo);
        }

        return '';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'reported' => 'Dilaporkan',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Selesai Ditangani',
            default => ucfirst($this->status),
        };
    }
}
