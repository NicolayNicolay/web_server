<?php

declare(strict_types=1);

namespace Modules\Controller\Services;

use Carbon\Carbon;
use Modules\Graph\AbstractGraph;
use Modules\Graph\GraphInterface;
use Modules\Temperatures\Models\Temperatures;

use function Modules\Control\Services\sort;

class ControllerGraphService extends AbstractGraph
{
    function __construct(Temperatures $temperatures)
    {
        parent::__construct($temperatures);
    }

    public function getData(): array
    {
        $carbon = (new Carbon());
        $end = $carbon->today()->format('Y-m-d H:i');
        $start = $carbon->today()->subDay()->format('Y-m-d H:i');
        $dates = [$start, $end];
        $data = $this->temperatures->select(
            [
                'value',
                'created_at as date',
            ]
        )->categoryValues('controller')
            ->whereBetween('created_at', $dates)
            ->get();
        $values = [];
        $x_label = [];
        //Соберем всевозможные даты для графика
        foreach ($data as $datum) {
            $x_label[] = $carbon::parse($datum['date'])->format('H:i F j, Y');
            $values[] = $datum['value'];
        }
        return [
            'labels' => $x_label,
            'values' => $values,
        ];
    }

    public function getGraph(): array
    {
        $colors = config('colors.values');
        $data = $this->getData();
        $result['line'] = [
            'show'       => false,
            'name'       => 'Controller',
            'type'       => "line",
            'showSymbol' => false,
            'emphasis'   => [
                'focus' => "series",
            ],
            'color'      => $colors[0],
            'itemStyle'  => [
                "color" => $colors[0],
            ],
            'lineStyle'  => [
                'width' => 4,
            ],
            'data'       => $data['values'] ?? [],
        ];
        $result['xAxis'] = [
            [
                'type'        => "category",
                'boundaryGap' => false,
                'data'        => $data['labels'] ?? [],
            ],
        ];
        return $result;
    }
}
