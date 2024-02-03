<?php

declare(strict_types=1);

namespace Modules\Status\Services;

use Illuminate\Http\Client\RequestException;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;
use Modules\Status\Resources\CarrierboardResource;
use Modules\Status\Resources\MotherboardResource;
use Modules\Status\Resources\StatusMotherboardResource;

class StatusService extends ApiService
{
    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    public function getFormatMotherboardsData(): array
    {
        $data = $this->getMotherboardsData();
        $result = [];
        foreach ($data as $datum) {
            if ($datum) {
                $result[] = (new MotherboardResource($datum))->toArray();
            }
        }
        return $result;
    }

    public function getActiveMotherboardsData(): array
    {
        $devices = $this->getActiveDevices();
        $devices_data = $this->getActiveDevicesData();
        $result = [];
        if ($devices) {
            foreach ($devices['Motherboard'] as $key => $datum) {
                $tmp_item = (new StatusMotherboardResource($datum))->toArray();
                $tmp_item['name'] = $key;
                $tmp_item['bottom'] = $devices_data['PSU_FRU']['FRU_Bottom']['Model'];
                $tmp_item['top'] = $devices_data['PSU_FRU']['FRU_Top']['Model'];
                $tmp_item['housing'] = $devices_data['PSU_FRU']['FRU_Housing']['Model'];
                $result[] = $tmp_item;
            }
        }
        return $result;
    }

    public function getActiveCarrierboardsData(): array
    {
        $devices = $this->getActiveDevices();
        $carrirboards = $this->getCarrierboardsData();
        $result = [];
        if ($devices) {
            foreach ($devices['Carrierboard'] as $key => $datum) {
                $tmp_item = $datum;
                $tmp_item['name'] = $key;
                $tmp_carrierboard = in_array($key, array_column($carrirboards, 'name')) ? $carrirboards[array_search($key, array_column($carrirboards, 'name'))] : null;
                if ($tmp_carrierboard) {
                    $tmp_item['num'] = $tmp_carrierboard['placement'];
                    $tmp_item['cpus'] = $tmp_carrierboard['full_status'];
                }
                $result[] = $tmp_item;
            }
        }
        return $result;
    }
}
