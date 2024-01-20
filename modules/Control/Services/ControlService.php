<?php

namespace Modules\Control\Services;

use Illuminate\Http\Client\RequestException;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Control\Resources\MotherboardResource;
use Modules\Errors\Services\ErrorsServices;

class ControlService extends ApiService
{

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    public function rebootAllCB(): ?bool
    {
        return $this->getStatusData('/control/rebootAll');
    }

    public function rebootSwitch($id): ?bool
    {
        return $this->getStatusData('/control/rebootSwitchCB/' . $id);
    }

    public function rebootUsb($id): ?bool
    {
        return $this->getStatusData('/control/rebootUSB/' . $id);
    }

    public function getControlMotherboardsData()
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
                if ($tmp_carrierboard) {
                    $tmp_item['id'] = $tmp_carrierboard['num'];
                    $tmp_item['insert_status'] = $tmp_carrierboard['insert_status'];
                    $tmp_item['placement'] = $tmp_carrierboard['placement'];
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

}
