<?php

namespace Modules\Cooling\Services;

use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;

class CoolingService extends ApiService
{

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }
}
