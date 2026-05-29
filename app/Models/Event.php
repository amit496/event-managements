<?php

namespace App\Models;

use App\Enums\EventStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Event extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'category_id',
        'avenue_id',
        'title',
        'slug',
        'description',
        'start_at',
        'end_at',
        'venue',
        'address',
        'latitude',
        'longitude',
        'image',
        'capacity',
        'price',
        'client_payable_amount',
        'event_status',
        'payment_required',
        'is_featured',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'latitude' => 'float',
            'longitude' => 'float',
            'capacity' => 'integer',
            'price' => 'decimal:2',
            'client_payable_amount' => 'decimal:2',
            'event_status' => EventStatus::class,
            'payment_required' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Event $event): void {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function avenue(): BelongsTo
    {
        return $this->belongsTo(Avenue::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EventPayment::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    public function totalReceivedAmount(): float
    {
        $successfulStatuses = [PaymentStatus::Paid->value, PaymentStatus::Partial->value];

        if ($this->relationLoaded('payments')) {
            return (float) $this->payments
                ->filter(function ($payment) use ($successfulStatuses): bool {
                    $status = $payment->payment_status instanceof PaymentStatus
                        ? $payment->payment_status->value
                        : (string) $payment->payment_status;

                    return in_array($status, $successfulStatuses, true);
                })
                ->sum('amount');
        }

        return (float) $this->payments()
            ->whereIn('payment_status', $successfulStatuses)
            ->sum('amount');
    }

    public function totalDueAmount(): ?float
    {
        if ($this->client_payable_amount === null) {
            return null;
        }

        return max((float) $this->client_payable_amount - $this->totalReceivedAmount(), 0);
    }

    public function collectionStatusLabel(): string
    {
        if ($this->client_payable_amount === null || (float) $this->client_payable_amount <= 0) {
            return 'Not Set';
        }

        $received = $this->totalReceivedAmount();
        $payable = (float) $this->client_payable_amount;

        if ($received <= 0) {
            return 'Pending';
        }

        if ($received < $payable) {
            return 'Partial';
        }

        return 'Received';
    }
}
