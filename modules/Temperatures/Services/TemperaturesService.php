<?php

declare(strict_types=1);

namespace Modules\Temperatures\Services;

use Carbon\Carbon;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;
use Modules\Temperatures\Models\Temperatures;

class TemperaturesService extends ApiService
{
    protected Temperatures $temperatures;

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    public function getControllerTemperature()
    {
        return $this->getData('/temperature/getControllerData');
    }
}
