<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'room_id',
        'start_date',
        'duration_months',
        'end_date',
        'rental_type',
        'total_price',
        'payment_scheme',
        'dp_amount',
        'remaining_amount',
        'status',
        'renewal_status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'duration_months' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->latest();
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'waiting_renewal_confirmation' => 'Antrian (Menunggu Konfirmasi Penghuni Lama)',
            'pending_payment' => 'Menunggu Pembayaran',
            'payment_under_review' => 'Menunggu Verifikasi Admin',
            'dp_paid' => 'DP Diterima (Belum Lunas)',
            'active' => 'Sewa Aktif',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getRenewalStatusLabelAttribute(): string
    {
        return match ($this->renewal_status) {
            'pending' => 'Belum Konfirmasi',
            'renewing' => 'Akan Memperpanjang Sewa',
            'moving_out' => 'Pindah / Tidak Memperpanjang',
            default => ucfirst($this->renewal_status),
        };
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_price, 0, ',', '.');
    }

    public function getFormattedDpAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->dp_amount, 0, ',', '.');
    }

    public function getFormattedRemainingAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->remaining_amount, 0, ',', '.');
    }
}
