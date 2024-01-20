<?php

namespace Modules\Temperatures\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Properties
 *
 * @mixin Builder
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Temperatures[] $values
 * @property-read int|null $property_values_count
 */
class TemperaturesCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'name',
        'code',
    ];
    /**
     * Связанные значения справочника
     *
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(Temperatures::class, 'category_id', 'id');
    }

    /**
     * Получаем id по коду
     *
     * @param $code
     * @return bool|mixed
     */
    public static function getIdByCode($code): mixed
    {
        $property_codes = Cache::remember(
            'temperatures_codes',
            86400,
            static function () {
                $codes = [];
                $res = (new self())->get();
                foreach ($res as $rubric) {
                    $codes[$rubric->code] = $rubric->id;
                }
                return $codes;
            }
        );
        return $property_codes[$code] ?? false;
    }

    public static function getIdByCodeWithoutCache($code)
    {
        $codes = [];
        $res = (new self())->get();
        foreach ($res as $rubric) {
            $codes[$rubric->code] = $rubric->id;
        }
        return $codes[$code] ?? false;
    }
}
