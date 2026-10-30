<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_code',
        'full_name',
        'email',
        'password',
        'birthdate',
        'event',
        'ticket_category',
        'quantity',
        'total_price',
        'confirmed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birthdate' => 'date',
            'quantity' => 'integer',
            'total_price' => 'integer',
            'confirmed_at' => 'datetime',
        ];
    }

    public static function newBookingCode(): string
    {
        do {
            $code = config('concert.code_prefix').'-'.Str::upper(Str::random(6));
        } while (static::where('booking_code', $code)->exists());

        return $code;
    }

    public static function rupiah(int $amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }

    public function ticketLabel(): string
    {
        return config("concert.tickets.{$this->ticket_category}.label", ucfirst($this->ticket_category));
    }

    public function unitPrice(): int
    {
        return (int) config("concert.tickets.{$this->ticket_category}.price", 0);
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed_at !== null;
    }
}
