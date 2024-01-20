<?php

namespace Modules\Controller\Services;

use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;

class ControllerService extends ApiService
{

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    public function getControllerData()
    {
        return $this->getData('/controller/getData');
    }
    //Выключение controller
    public function powerOff(): ?bool
    {
        return $this->getStatusData('/controller/off');
    }

    public function softReboot(): ?bool
    {
        return $this->getStatusData('/controller/softReboot');
    }

    public function hardReboot(): ?bool
    {
        return $this->getStatusData('/controller/hardReboot');
    }
}
