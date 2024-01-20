<?php

declare(strict_types=1);

namespace Modules\Temperatures\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Modules\Api\Api;
use Modules\Api\Services\ApiService;
use Modules\Errors\Services\ErrorsServices;
use Modules\Temperatures\Models\Temperatures;
use Modules\Temperatures\Models\TemperaturesCategories;

class TemperaturesApiService extends ApiService
{

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        parent::__construct($api, $errorsServices);
    }

    //Получение данных температуры по Carrierboards и Motherboards
    public function getMainData(): void
    {
        try {
            $data = $this->api->get('/temperature/getData');
            if ($data['data']) {
                foreach ($data['data']['categories'] as $category_key => $category) {
                    foreach ($category as $item) {
                        (new Temperatures())->create(
                            [
                                'category_id' => $this->categories[$category_key],
                                'name'        => $item['name'],
                                'value'       => $item['temperature'],
                            ]
                        );
                    }
                }
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, ['temperature', 'mb_cb']);
        }
    }

    //Psus data
    public function getPsusData(): void
    {
        try {
            $data = $this->api->get('/temperature/getPsusData');
            if ($data['data']) {
                $bottom = array_search('Bottom', array_column($data['data'], 'name'));
                $top = array_search('Top', array_column($data['data'], 'name'));
                $res = [
                    'category_id' => $this->categories['psu'],
                    'name'        => 'psu',
                ];
                if ($bottom !== false) {
                    $res['bottom'] = $data['data'][$bottom]['temperature'];
                }
                if ($top !== false) {
                    $res['top'] = $data['data'][$top]['temperature'];
                }
                (new Temperatures())->create($res);
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, ['temperature', 'psu']);
        }
    }

    //Cpus data
    public function getCpuData(): void
    {
        //Пока выдает ошибку, не понятно каким видом будет обладать
        try {
            $data = $this->api->get('/temperature/getCpusData');
            if ($data['data']) {
                $res = [
                    'category_id' => $this->categories['controller'],
                    'name'        => $data['data']['name'],
                    'value'       => $data['data']['temperature'],
                ];
                (new Temperatures())->create($res);
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, ['temperature', 'cpu']);
        }
    }

    public function getControllerData(): void
    {
        //Controller
        try {
            $data = $this->api->get('/temperature/getControllerData');
            if ($data['data']) {
                $res = [
                    'category_id' => $this->categories['controller'],
                    'name'        => $data['data']['name'],
                    'value'       => $data['data']['temperature'],
                ];
                (new Temperatures())->create($res);
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, ['temperature', 'controller']);
        }
    }

    public function getSwitchData(): void
    {
        //Switch
        try {
            $data = $this->api->get('/temperature/getSwitchData');
            if ($data['data']) {
                $res = [
                    'category_id' => $this->categories['switch'],
                    'name'        => $data['data']['name'],
                    'value'       => $data['data']['temperature'],
                ];
                (new Temperatures())->create($res);
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, ['temperature', 'switch']);
        }
    }

    public function getControllerTemperature()
    {
        return $this->getData('/temperature/getControllerData');
    }
}
