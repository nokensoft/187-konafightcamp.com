<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'member_code',
        'phone',
        'gender',
        'date_of_birth',
        'id_type',
        'id_number',
        'id_photo_path',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'membership_package',
        'membership_type',
        'registration_date',
        'expiry_date',
        'notes',
        'terms_accepted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'registration_date' => 'date',
            'expiry_date' => 'date',
            'terms_accepted_at' => 'datetime',
        ];
    }

    /**
     * The auth account this member profile belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Build a stable, unique member code from the linked user id.
     * Offset by 100 so generated codes never collide with the MB001–MB005
     * prototype members seeded from resources/data/gym.json.
     */
    public static function codeForUser(int $userId): string
    {
        return 'MB'.str_pad((string) (100 + $userId), 3, '0', STR_PAD_LEFT);
    }

    /**
     * Whether the membership is still active (no expiry, or expiry in the future).
     */
    public function isActive(): bool
    {
        return $this->expiry_date === null || $this->expiry_date->endOfDay()->isFuture();
    }

    /**
     * Map this member to the shape the Alpine POS app expects for its table.
     *
     * @return array<string, mixed>
     */
    public function toPosArray(): array
    {
        return [
            'id' => $this->member_code,
            'name' => $this->user?->name ?? 'Member',
            'gender' => $this->gender ?: '',
            'package' => $this->membership_package ?: 'Pending',
            'type' => $this->membership_type ?: 'Local',
            'idNumber' => $this->id_number ?: '',
            'idPhotoUrl' => $this->id_photo_path ? asset('storage/' . $this->id_photo_path) : null,
            'address' => $this->address ?: '',
            'notes' => $this->notes ?: '',
            'registrationDate' => $this->registration_date?->format('d M Y') ?? '',
            'expiry' => $this->expiry_date?->format('d M Y') ?? 'Pending',
        ];
    }
}
