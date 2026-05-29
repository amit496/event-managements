<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: static function (mixed $value): CategoryStatus {
                return match ((string) $value) {
                    'active', '1', 'true' => CategoryStatus::Active,
                    'inactive', '0', 'false' => CategoryStatus::Inactive,
                    default => CategoryStatus::Inactive,
                };
            },
            set: static function (mixed $value): string {
                if ($value instanceof CategoryStatus) {
                    return $value->value;
                }

                return match ((string) $value) {
                    'active', '1', 'true' => CategoryStatus::Active->value,
                    default => CategoryStatus::Inactive->value,
                };
            }
        );
    }

    protected static function booted(): void
    {
        static::saving(function (Category $category): void {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
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
