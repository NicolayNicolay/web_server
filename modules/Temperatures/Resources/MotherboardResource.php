<?php

declare(strict_types=1);

namespace Modules\Temperatures\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Temperatures\Models\Temperatures;

/**
 * Class MotherboardResource
 *
 * @mixin Temperatures
 * @package Modules\Temperatures
 */
class MotherboardResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'value'      => $this->value,
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i:s'),
        ];
    }
}
