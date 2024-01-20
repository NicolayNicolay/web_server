<?php

namespace Modules\Server\Controllers;

use Illuminate\Http\Client\RequestException;
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

    public function getStatus()
    {
        return $this->service->getStatusServer();
    }

    public function inventory(): ?bool
    {
        return $this->service->inventoryNow();
    }

    public function initDevices(): ?bool
    {
        return $this->service->initDevices();
    }

    public function serverOn(): ?bool
    {
        return $this->service->serverOn();
    }

    public function serverOff(): ?bool
    {
        return $this->service->serverOff();
    }

    public function serverReboot(): ?bool
    {
        return $this->service->serverReboot();
    }
}
