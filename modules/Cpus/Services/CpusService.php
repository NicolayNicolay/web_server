<?php

namespace Modules\Cpus\Services;

use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;

class CpusService extends ApiService
{

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }
    //Включение одного или нескольких CPU
    public function powerOn($ids): ?bool
    {
        return $this->postStatusData('/cpus/on', ['ids' => $ids]);
    }

    //Выключение одного или нескольких CPU
    public function powerOff($ids): ?bool
    {
        return $this->postStatusData('/cpus/off', ['ids' => $ids]);
    }

    //Перезапуск одного или нескольких CPU
    public function powerReboot($ids): ?bool
    {
        return $this->postStatusData('/cpus/reboot', ['ids' => $ids]);
    }
}
