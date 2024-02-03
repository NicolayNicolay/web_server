<?php

declare(strict_types=1);

namespace Modules\Cpus\Controllers;

use Illuminate\Http\Request;
use Modules\Cpus\Services\CpuGraphService;
use Modules\Cpus\Services\CpusService;

class CpusController
{
    private CpusService $service;

    public function __construct(CpusService $service)
    {
        $this->service = $service;
    }

    public function getData(CpuGraphService $service): array
    {
        return $service->getGraph();
    }

    public function powerOn(Request $request): bool
    {
        $ids = $request->input('ids');
        return $this->service->powerOn($ids);
    }

    public function powerOff(Request $request): bool
    {
        $ids = $request->input('ids');
        return $this->service->powerOff($ids);
    }

    public function powerReboot(Request $request): bool
    {
        $ids = $request->input('ids');
        return $this->service->powerReboot($ids);
    }
}
