<?php

namespace Modules\Status\Services;

use Illuminate\Http\Client\RequestException;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;
use Modules\Status\Resources\CarrierboardResource;
use Modules\Status\Resources\MotherboardResource;

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
        $data = $this->getActiveDevices();
        $result = [];
        if ($data) {
            foreach ($data['Motherboard'] as $key => $datum) {
                $tmp_item = $datum;
                $tmp_item['name'] = $key;
                $tmp_item['switch'] = $data['Switch']['Model'];
                $tmp_item['Bottom'] = $data['PSU_FRU']['FRU_Bottom'];
                $tmp_item['Top'] = $data['PSU_FRU']['FRU_Top'];
                $tmp_item['Housing'] = $data['PSU_FRU']['FRU_Housing'];
                $result[] = $tmp_item;
            }
        }
        return $result;
    }

    public function getActiveCarrierboardsData(): array
    {
        $data = $this->getActiveDevices();
        $carrirboards = $this->getCarrierboardsData();
        $result = [];
        if ($data) {
            foreach ($data['Carrierboard'] as $key => $datum) {
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
