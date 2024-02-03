<?php

declare(strict_types=1);

namespace Modules\Server\Controllers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Modules\Control\Services\CpusService;
use Modules\Server\Services\ServerService;
use Modules\Status\Services\StatusService;

class ServerController
{
    private ServerService $service;

    public function __construct(ServerService $service)
    {
        $this->service = $service;
    }

    public function getStatus(): ?array
    {
        return [
            'status'         => $this->service->getStatusServer(),
            'inventory_time' => $this->service->getInventoryTime(),
            'devices'        => $this->service->getDevicesData(),
        ];
    }

    public function inventory(): JsonResponse | bool
    {
        return $this->service->inventoryNow();
    }

    public function initDevices(): JsonResponse | bool
    {
        return $this->service->initDevices();
    }

    public function serverOn(): JsonResponse | bool
    {
        return $this->service->serverOn();
    }

    public function serverOff(): JsonResponse | bool
    {
        return $this->service->serverOff();
    }

    public function serverReboot(): JsonResponse | bool
    {
        return $this->service->serverReboot();
    }
}
