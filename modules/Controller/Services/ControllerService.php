<?php

declare(strict_types=1);

namespace Modules\Controller\Services;

use Illuminate\Http\JsonResponse;
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
    public function powerOff(): JsonResponse | bool
    {
        return $this->getStatusData('/controller/off');
    }

    public function softReboot(): JsonResponse | bool
    {
        return $this->getStatusData('/controller/softReboot');
    }

    /**
     */
//    Так как выяснился аппаратный нюанс, при перезапуске контроллера данным методом, ответ получен быть не может, т.к сразу начинается процесс перезапуска и он становится недоступен.
    public function hardReboot(): JsonResponse | bool
    {
        try {
            $this->api->get('/controller/hardReboot', [], 1);
            return true;
        } catch (\Exception $exception) {
            return true;
        }
    }
}
