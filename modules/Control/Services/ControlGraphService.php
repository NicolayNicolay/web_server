<?php

declare(strict_types=1);

namespace Modules\Control\Services;

use Carbon\Carbon;
use Modules\Graph\AbstractGraph;
use Modules\Temperatures\Models\Temperatures;

class ControlGraphService extends AbstractGraph
{
    function __construct(Temperatures $temperatures)
    {
        parent::__construct($temperatures);
    }

    public function getData(): array
    {
        $carbon = new Carbon();
        $all_dates = $this->getMonthRangeDate();
        $items = $this->getFullDatesData(['motherboards', 'carrierboards']);
        foreach ($all_dates as &$label) {
            $label = $carbon::parse($label)->format('F j, Y');
        }
        return [
            'items'   => $items['data'],
            'legends' => $items['legends'],
            'labels'  => $all_dates,
        ];
    }

    public function getGraph(): array
    {
        $colors = config('colors.values');
        $data = $this->getData();
        $result = [
            'series' => []
        ];
        $key = 0;
        if($data['items']) {
            foreach ($data['items'] as $datum) {
                $result['series'][] = [
                    'show'       => false,
                    'name'       => $datum['name'],
                    'type'       => "line",
                    // areaStyle: [],
                    'showSymbol' => false,
                    'emphasis'   => [
                        'focus' => "series",
                    ],
                    'color'      => $colors[$key],
                    'itemStyle'  => [
                        "color" => $colors[$key],
                    ],
                    'lineStyle'  => [
                        "width" => 2,
                    ],
                    'data'       => $datum['data'],
                ];
                $key++;
            }
        }
        $result['xAxis'] = [
            [
                'type'        => "category",
                'boundaryGap' => false,
                'data'        => $data['labels']?? [],
            ],
        ];
        $result['legend'] = $data['legends']?? [];
        return $result;
    }
}
