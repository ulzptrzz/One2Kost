<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'name',
        'room_type_id',
        'floor',
        'monthly_price',
        'annual_price',
        'size',
        'description',
        'main_image',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'monthly_price' => 'decimal:2',
        'annual_price' => 'decimal:2',
    ];

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function facilityItems(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_room')->withTimestamps();
    }

    public function getRoomTypeAttribute(): string
    {
        return $this->roomType()->first()?->name ?? '-';
    }

    public function getFacilitiesAttribute(): array
    {
        return $this->facilityItems()->pluck('facilities.name')->all();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class)->latest();
    }

    public function activeBooking()
    {
        return $this->hasOne(Booking::class)
            ->whereIn('status', ['active', 'dp_paid'])
            ->latestOfMany();
    }

    public function activeTenant()
    {
        return $this->hasOneThrough(
            User::class,
            Booking::class,
            'room_id',
            'id',
            'id',
            'user_id'
        )->whereIn('bookings.status', ['active', 'dp_paid']);
    }

    public function damageReports()
    {
        return $this->hasMany(DamageReport::class)->latest();
    }

    public function guestReports()
    {
        return $this->hasMany(GuestReport::class)->latest();
    }

    public function getAllImagesUrlsAttribute(): array
    {
        $paths = [];

        if (!empty($this->main_image)) {
            $paths[] = $this->main_image;
        }

        if (is_array($this->images)) {
            foreach ($this->images as $img) {
                if (!empty($img) && !in_array($img, $paths)) {
                    $paths[] = $img;
                }
            }
        }

        if (empty($paths)) {
            return ['https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80'];
        }

        return array_map(function ($path) {
            return str_starts_with($path, 'http') ? $path : asset($path);
        }, $paths);
    }

    public function getMainImageUrlAttribute(): string
    {
        return $this->all_images_urls[0];
    }

    public function getFormattedMonthlyPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->monthly_price, 0, ',', '.');
    }

    public function getFormattedAnnualPriceAttribute(): string
    {
        return $this->annual_price ? 'Rp ' . number_format((float) $this->annual_price, 0, ',', '.') : '-';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'pending_renewal' => 'Menunggu Konfirmasi Perpanjangan',
            default => 'Tersedia',
        };
    }
}