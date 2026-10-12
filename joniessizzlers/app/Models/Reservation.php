<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Reservation extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_DECLINED = 'declined';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_NO_SHOW = 'no_show';

    protected $fillable = [
        'reference_number',
        'customer_name',
        'contact_number',
        'branch_id',
        'reservation_date',
        'reservation_time',
        'guest_count',
        'additional_requests',
        'status',
        'policy_accepted',
        'policy_accepted_at',
        'processed_by_user_id',
        'processed_at',
        'decline_reason',
        'cancellation_reason',
    ];

    protected $casts = [
        'policy_accepted' => 'boolean',
        'policy_accepted_at' => 'datetime',
        'processed_at' => 'datetime',
        'guest_count' => 'integer',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_DECLINED => 'Declined',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_NO_SHOW => 'No Show',
        ];
    }

    public static function statusTransitions(): array
    {
        return [
            self::STATUS_PENDING => [self::STATUS_CONFIRMED, self::STATUS_DECLINED],
            self::STATUS_CONFIRMED => [self::STATUS_COMPLETED, self::STATUS_CANCELLED, self::STATUS_DECLINED],
            self::STATUS_DECLINED => [self::STATUS_CANCELLED],
            self::STATUS_CANCELLED => [],
            self::STATUS_COMPLETED => [],
            self::STATUS_NO_SHOW => [],
        ];
    }

    public static function generateReferenceNumber(): string
    {
        do {
            $reference = 'JNS-' . strtoupper(Str::random(6));
        } while (self::query()->where('reference_number', $reference)->exists());

        return $reference;
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by_user_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ReservationActivity::class)->orderByDesc('created_at');
    }
}
