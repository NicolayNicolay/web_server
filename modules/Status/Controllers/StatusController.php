<?php

declare(strict_types=1);

namespace Modules\Status\Controllers;

use Illuminate\Http\Client\RequestException;
use Modules\Status\Services\StatusService;

class StatusController
{
    private StatusService $service;

    public function __construct(StatusService $service)
    {
        $this->service = $service;
    }

    /**
     */
    public function getData(): array
    {
        return [
            'status'         => $this->service->getStatusServer(),
            'uptime'         => $this->service->getUptimeServer(),
            'inventory_time' => $this->service->getInventoryTime(),
            'carrierboards'  => $this->service->getCarrierboardsData(),
            'motherboards'   => $this->service->getFormatMotherboardsData(),
            'devices'        => $this->service->getDevicesData(),
        ];
    }

    public function getActiveDevices(): array
    {
        return [
            'motherboards'  => $this->service->getActiveMotherboardsData(),
            'carrierboards' => $this->service->getActiveCarrierboardsData(),
            'devices'       => $this->service->getDevicesData(),
            'inventory_time' => $this->service->getInventoryTime(),
        ];
    }
}
