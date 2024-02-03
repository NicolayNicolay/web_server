<?php

declare(strict_types=1);

namespace Modules\Cooling\Controllers;

use Illuminate\Http\Request;
use Modules\Controller\Services\ControllerGraphService;
use Modules\Controller\Services\ControllerService;
use Modules\Cooling\Services\CoolingGraphService;
use Modules\Temperatures\Services\TemperaturesService;

class CoolingController
{
    public function getData(CoolingGraphService $service): array
    {
        return $service->getGraph();
    }
}
