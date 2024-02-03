<?php

declare(strict_types=1);

namespace Modules\Graph;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Modules\Temperatures\Models\Temperatures;

abstract class AbstractGraph
{
    protected Temperatures $temperatures;

    public function __construct(Temperatures $temperatures)
    {
        $this->temperatures = $temperatures;
    }

    abstract public function getData();

    abstract public function getGraph();

    public function getElementData(string $code, string $value = 'value'): array
    {
        $dates = $this->getLastMonthRangeDate();
        return [
            'data' => $this->temperatures->select(
                [
                    $this->temperatures->raw('ROUND(avg(' . $value . ')) as value'),
                    $this->temperatures->raw('date(created_at) as date'),
                ]
            )->categoryValues($code)
                ->whereBetween('created_at', $dates)
                ->groupBy($this->temperatures->raw('date(`created_at`)'))
                ->pluck('value', 'date')
                ->toArray(),
            'code' => $code,
        ];
    }

    public function getElementsData($code): Collection | array
    {
        $dates = $this->getLastMonthRangeDate();
        return $this->temperatures->select(
            [
                'name',
                $this->temperatures->raw('ROUND(avg(value)) as value'),
                $this->temperatures->raw('date(created_at) as date'),
            ]
        )->categoryValues($code)
            ->whereBetween('created_at', $dates)
            ->groupBy('name', $this->temperatures->raw('date(`created_at`)'))
            ->get();
    }

    public function getLastMonthRangeDate(): array
    {
        $carbon = new Carbon();
        $end_between = $carbon->today()->format('Y-m-d') . ' 23:59';
        $start_between = $carbon->today()->subMonth()->format('Y-m-d') . ' 00:00';
        return [$start_between, $end_between];
    }

    public function getMonthRangeDate(string $format = ''): array
    {
        $carbon = new Carbon();
        $end = new Carbon($carbon->today());
        $start = new Carbon($carbon->today()->subMonth()->format('Y-m-d'));
        $all_dates = [];
        while ($start->lte($end)) {
            $all_dates[] = $start->toDateString();
            $start->addDay();
        }
        if ($format) {
            $data = [];
            foreach ($all_dates as $date) {
                $data[] = $carbon::parse($date)->format($format);
            }
            return $data;
        }
        return $all_dates;
    }

    public function makeElementsArray(array | string $codes): array
    {
        $data = [];
        if (is_array($codes)) {
            foreach ($codes as $code) {
                $data = $this->getArr($code, $data);
            }
        } else {
            $data = $this->getArr($codes, $data);
        }
        return $data;
    }

    /**
     * @param string $codes
     * @param array $data
     * @return array
     */
    public function getArr(string $codes, array $data): array
    {
        $items = $this->getElementsData($codes);
        $formatted_items = [];
        foreach ($items as $item) {
            if (! array_key_exists($item['name'], $formatted_items)) {
                $formatted_items[$item['name']] = [];
            }
            if (! array_key_exists('code', $formatted_items[$item['name']])) {
                $formatted_items[$item['name']]['code'] = $codes;
            }
            $formatted_items[$item['name']]['dates'][$item['date']] = $item['value'];
        }
        return array_merge($data, $formatted_items);
    }

    public function getFullDatesData(array | string $codes): ?array
    {
        $data = [];
        $legends = [];
        $array = $this->makeElementsArray($codes);
        $all_dates = $this->getMonthRangeDate();
        if ($array) {
            foreach ($array as $key => $item) {
                $data[$key] = [
                    'name' => $key,
                    'code' => $item['code'],
                ];
                $legends[] = $key;
                foreach ($all_dates as $date) {
                    if (! array_key_exists($date, $item['dates'])) {
                        $data[$key]['data'][] = 0;
                    } else {
                        $data[$key]['data'][] = $item['dates'][$date];
                    }
                }
            }
        } else {
            return null;
        }
        return [
            'data'    => $data,
            'legends' => $legends,
        ];
    }
}
