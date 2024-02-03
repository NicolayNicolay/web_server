<?php

declare(strict_types=1);

namespace Modules\Control\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Control\Resources\MotherboardResource;
use Modules\Errors\Services\ErrorsServices;
use Modules\Traites\DataTrait;

class ControlService extends ApiService
{
    use DataTrait;

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    public function rebootAllCB(): JsonResponse | bool
    {
        return $this->getStatusData('/control/rebootAll');
    }

    public function rebootSwitch($id): JsonResponse | bool
    {
        return $this->getStatusData('/control/rebootSwitchCB/' . $id);
    }

    public function rebootUsb($id): JsonResponse | bool
    {
        return $this->getStatusData('/control/rebootUSB/' . $id);
    }

    public function getControlMotherboardsData(): array
    {
        $data = $this->getData('/control/MotherboardsData');
        $result = [];
        if ($data) {
            foreach ($data as $datum) {
                $result[] = (new MotherboardResource($datum))->toArray();
            }
        }
        return $result;
    }

    public function getControlCarrierboardsData()
    {
        return $this->getData('/control/CarrierboardsData');
    }

    public function getMbCbData(): array
    {
        $motherboards = $this->getControlMotherboardsData();
        $carrierboards = $this->getControlCarrierboardsData();
        $add_carrierboards = $this->getCarrierboardsData();
        $cb_result = [];
        $result = [];
        if ($carrierboards && $add_carrierboards) {
            foreach ($carrierboards as $datum) {
                $tmp_item = $datum;
                $tmp_carrierboard = in_array($tmp_item['name'], array_column($add_carrierboards, 'name')) ? $add_carrierboards[array_search($tmp_item['name'], array_column($add_carrierboards, 'name'))] : null;
                $tmp_item['5v_cpu_status'] = $tmp_carrierboard['v_cpu_status'];
                if ($tmp_carrierboard) {
                    $tmp_item['id'] = $tmp_carrierboard['num'];
                    $tmp_item['insert_status'] = $tmp_carrierboard['insert_status'];
                    $tmp_item['placement'] = $tmp_carrierboard['placement'];
                    $cpu_voltage = $tmp_item['5v_cpu_voltage'];
                    $tmp_item['5v_cpu_voltage'] = [
                        'value' => $cpu_voltage,
                        'class' => $tmp_item['insert_status']['value'] === 'Absent' ? 'table-secondary' : $this->getCpuVoltageClass($cpu_voltage),
                    ];
                    $cpu_power = $tmp_item['5v_cpu_power'];
                    $tmp_item['5v_cpu_power'] = [
                        'value' => $cpu_power,
                        'class' => $tmp_item['insert_status']['value'] === 'Absent' ? 'table-secondary' : $this->getCpuPowerClass($cpu_power),
                    ];
                }
                $cb_result[] = $tmp_item;
            }
        }
        if ($motherboards) {
            foreach ($motherboards as $motherboard) {
                $result[$motherboard['name']]['motherboard'] = $motherboard;
            }
        }
        if ($cb_result) {
            foreach ($cb_result as $item) {
                $result[$item['mb_name']]['carrierboards'][] = $item;
            }
        }
        return $result;
    }

    private function getCpuVoltageClass($value): string
    {
        $value = (float) $value;
        if ($value >= 4.9 && $value <= 5.1) {
            return 'table-success';
        }
        if (($value >= 4.75 && $value < 4.9) || ($value > 5.1 && $value <= 5.25)) {
            return 'table-warning';
        }
        if ($value < 4.75 || $value > 5.25) {
            return 'table-danger';
        }
        return '';
    }

    private function getCpuPowerClass($value): string
    {
        $value = (float) $value;
        if ($value < 6) {
            return 'table-success';
        }
        if ($value >= 7 && $value <= 9) {
            return 'table-warning';
        }
        if ($value > 9) {
            return 'table-danger';
        }
        return '';
    }
}
