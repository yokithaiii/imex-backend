<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TenderCategory extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tender_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'sort_order',
        'parent_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Генерируем slug из name, если он не указан
            $model->slug = $model->createUniqueSlug($model->name);
        });

        static::updating(function ($model) {
            // При обновлении name обновляем и slug
            if ($model->isDirty('name')) {
                $model->slug = $model->createUniqueSlug($model->name);
            }
        });
    }

    protected function createUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Проверяем на уникальность
        while (static::query()->where('slug', $slug)->where('id', '!=', $this->id ?? null)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }
}
