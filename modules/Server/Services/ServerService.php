<?php

namespace Modules\Server\Services;

use Illuminate\Http\Client\RequestException;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;

class ServerService extends ApiService
{

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    public function serverOn(): ?bool
    {
        return $this->getStatusData('/server/on');
    }

    public function serverOff(): ?bool
    {
        return $this->getStatusData('/server/off');
    }

    public function serverReboot(): ?bool
    {
        return $this->getStatusData('/server/reboot');
    }
}
