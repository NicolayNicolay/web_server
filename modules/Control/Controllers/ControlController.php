<?php

namespace Modules\Control\Controllers;

use Modules\Control\Services\ControlGraphService;
use Modules\Control\Services\ControlService;

class ControlController
{
    private ControlService $service;

    public function __construct(ControlService $service)
    {
        $this->service = $service;
    }

    public function getMainPowerData(): array
    {
        return [
            'status'         => $this->service->getStatusServer(),
            'devices'        => $this->service->getDevicesData(),
            'inventory_time' => $this->service->getInventoryTime(),
        ];
    }

    public function getControlData(ControlGraphService $service): array
    {
        return $service->getGraph();
    }

    public function rebootAllCB(): ?bool
    {
        return $this->service->rebootAllCB();
    }

    public function rebootSwitch(int $id): ?bool
    {
        return $this->service->rebootSwitch($id);
    }

    public function rebootUsb(int $id): ?bool
    {
        return $this->service->rebootUsb($id);
    }

    public function getMbCbData(): array
    {
        return $this->service->getMbCbData();
    }
}
