<?php

namespace Modules\Controller\Controllers;

use Illuminate\Http\Request;
use Modules\Controller\Services\ControllerGraphService;
use Modules\Controller\Services\ControllerService;
use Modules\Temperatures\Services\TemperaturesService;

class ControllerController
{
    private ControllerService $service;

    public function __construct(ControllerService $service)
    {
        $this->service = $service;
    }

    public function getData(TemperaturesService $service, ControllerGraphService $graphService): array
    {
        return [
            'data'        => $this->service->getControllerData(),
            'temperature' => $service->getControllerTemperature(),
            'options'     => $graphService->getGraph(),
        ];
    }


    public function powerOff(): bool
    {
        return $this->service->powerOff();
    }

    public function softReboot(): bool
    {
        return $this->service->softReboot();
    }

    public function hardReboot(): bool
    {
        return $this->service->hardReboot();
    }
}
