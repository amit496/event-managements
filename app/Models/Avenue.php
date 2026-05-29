<?php

namespace App\Models;

use App\Enums\AvenueStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Avenue extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'place',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'location_images',
        'event_room_images',
        'building_images',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'location_images' => 'array',
            'event_room_images' => 'array',
            'building_images' => 'array',
            'status' => AvenueStatus::class,
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Avenue $avenue): void {
            if (empty($avenue->slug)) {
                $avenue->slug = Str::slug($avenue->name.'-'.$avenue->city);
            }
        });
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
