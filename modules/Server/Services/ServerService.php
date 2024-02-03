<?php

declare(strict_types=1);

namespace Modules\Server\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;

class ServerService extends ApiService
{
    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    public function serverOn(): JsonResponse | bool
    {
        return $this->getStatusData('/server/on');
    }

    public function serverOff(): JsonResponse | bool
    {
        return $this->getStatusData('/server/off');
    }

    public function serverReboot(): JsonResponse | bool
    {
        return $this->getStatusData('/server/reboot');
    }
}
