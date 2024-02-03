<?php

declare(strict_types=1);

namespace Modules\Traites;

trait DataTrait
{
    public function getTableStatus($value): array
    {
        $res = [
            'value' => $value,
        ];
        $res['class'] = match ($value) {
            'Good' => 'table-success',
            'Fault' => 'table-danger',
            default => 'table-secondary',
        };
        return $res;
    }
}
