<?php

declare(strict_types=1);

namespace Modules\Temperatures\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Temperatures
 *
 * @mixin Builder
 *
 * @property int $id
 * @property int $category_id Список из таблицы temperatures_categories
 * @property string $name
 * @property string $value
 * @property string $bottom
 * @property string $top
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read TemperaturesCategories $property
 *
 * @method static Builder|Temperatures categoryValues($category_code)
 */
class Temperatures extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'name',
        'value',
        'bottom',
        'top',
        'category_id',
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i:s',
        'updated_at' => 'date:d.m.Y H:i:s',
    ];

    /**
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(TemperaturesCategories::class, 'id', 'category_id');
    }

    /**
     * Выборка по коду категории
     *
     * @param Builder $query
     * @param $category_code
     * @return Builder
     */
    public function scopeCategoryValues(Builder $query, $category_code): Builder
    {
        $category_id = TemperaturesCategories::getIdByCode($category_code);
        return $query->where('category_id', '=', $category_id);
    }
}
