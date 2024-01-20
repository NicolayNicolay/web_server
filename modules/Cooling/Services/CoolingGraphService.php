<?php

declare(strict_types=1);

namespace Modules\Cooling\Services;

use Carbon\Carbon;
use Modules\Controller\Services\ControllerGraphService;
use Modules\Graph\AbstractGraph;
use Modules\Graph\GraphInterface;
use Modules\Temperatures\Models\Temperatures;

use Modules\Temperatures\Models\TemperaturesCategories;

use function Modules\Control\Services\sort;

class CoolingGraphService extends AbstractGraph
{
    function __construct(Temperatures $temperatures)
    {
        parent::__construct($temperatures);
    }

    public function getData(): array
    {
        $data = [];
        $controller = $this->getCorrectData($this->getElementData('controller'), 'Controller');
        $switch = $this->getCorrectData($this->getElementData('switch'), 'Switch');
        $psu_bottom = $this->getCorrectData($this->getElementData('psu', 'bottom'), 'PSU Bottom');
        $psu_top = $this->getCorrectData($this->getElementData('psu', 'top'), 'PSU Top');
        $cpus = $this->getFullDatesData('cpu');
        array_push($data, $controller, $switch, $psu_bottom, $psu_top);
        $labels = $this->getMonthRangeDate('F j, Y');
        return [
            'items'  => $cpus ? array_merge($data, $cpus['data']) : $data,
            'labels' => $labels,
        ];
    }

    public function getGraph(): array
    {
        $colors = config('colors.values');
        $data = $this->getData();
        $result = [
            'series' => []
        ];
        $labels = [];
        $key = 0;
        $categories = TemperaturesCategories::pluck('id', 'code')->toArray();
        if($data['items']) {
            foreach ($data['items'] as $datum) {
                $result['series'][] = [
                    'dataGroupId' => $categories[$datum['code']],
                    'show'        => false,
                    'name'        => $datum['name'],
                    'type'        => "line",
                    // areaStyle: [],
                    'showSymbol'  => false,
                    'emphasis'    => [
                        'focus' => "series",
                    ],
                    'color'       => $colors[$key],
                    'itemStyle'   => [
                        "color" => $colors[$key],
                    ],
                    'lineStyle'   => [
                        "width" => 2,
                    ],
                    'data'        => $datum['data'],
                ];
                $labels[] = $datum['name'];
                $key++;
            }
        }
        $result['xAxis'] = [
            [
                'type'        => "category",
                'boundaryGap' => false,
                'data'        => $data['labels'] ?? [],
            ],
        ];
        $result['legend'] = $labels;
        $result['categories'] = $categories;
        return $result;
    }

    public function getCorrectData(array $array, string $name): array
    {
        $data = [];
        $all_dates = $this->getMonthRangeDate();
        foreach ($all_dates as $date) {
            if (! array_key_exists($date, $array['data'])) {
                $data[] = 0;
            } else {
                $data[] = $array['data'][$date];
            }
        }

        return [
            'data' => $data,
            'name' => $name,
            'code' => $array['code'],
        ];
    }
}
