<?php

namespace Modules\Temperatures\Controllers;

use Illuminate\Http\Client\RequestException;
use Modules\Api\Api;
use Modules\Status\Services\StatusService;
use Modules\Temperatures\Services\TemperaturesService;

class TemperaturesController
{
    private TemperaturesService $service;

    public function __construct(TemperaturesService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws RequestException
     */
    public function getData(): array
    {
        return $this->service->getTestData();
    }

    /**
     * @throws RequestException
     */
    public function getMainData(): ?array
    {
        return $this->service->getTestData();
    }

    /**
     * @throws RequestException
     */
    public function getSwitchData(): ?array
    {
        return $this->service->getSwitchData();
    }

    /**
     * @throws RequestException
     */
    public function getControllerData(): ?array
    {
        return $this->service->getControllerData();
    }
}
