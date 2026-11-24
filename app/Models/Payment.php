<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'bank_account_id',
        'payment_type',
        'amount',
        'payment_date',
        'proof_image',
        'sender_name',
        'sender_bank',
        'status',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getProofImageUrlAttribute(): string
    {
        if (!empty($this->proof_image)) {
            if (str_starts_with($this->proof_image, 'http')) {
                return $this->proof_image;
            }
            return asset($this->proof_image);
        }

        return '';
    }

    public function getStatusLabelAttribute(): string
    {
        if (empty($this->proof_image)) {
            return 'None';
        }

        return match ($this->status) {
            'pending' => 'Diproses',
            'approved' => 'Diterima / Disetujui',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        return match ($this->payment_type) {
            'dp' => 'Uang Muka (DP)',
            'full' => 'Bayar Lunas',
            'settlement' => 'Pelunasan Sisa',
            default => ucfirst($this->payment_type),
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->amount, 0, ',', '.');
    }
}
