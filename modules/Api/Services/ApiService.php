<?php

declare(strict_types=1);

namespace Modules\Api\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Modules\Api\Api;
use Modules\Errors\Services\ErrorsServices;
use Modules\Status\Resources\CarrierboardResource;
use Modules\Temperatures\Models\TemperaturesCategories;

abstract class ApiService
{
    protected Api $api;
    protected array $categories;
    protected ErrorsServices $errors;

    public function __construct(Api $api, ErrorsServices $errorsServices)
    {
        $this->api = $api;
        $this->categories = $this->getCategories();
        $this->errors = $errorsServices;
    }

    public function getCategories(): array
    {
        return TemperaturesCategories::query()->pluck('id', 'code')->toArray();
    }

    public function getData($url)
    {
        try {
            $data = $this->api->get($url);
            if ($data['data']) {
                return $data['data'];
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, $url);
        }
        return null;
    }

    public function getStatusData($url): JsonResponse | bool
    {
        try {
            $data = $this->api->get($url);
            if ($data['data']) {
                return true;
            }
        } catch (RequestException $requestException) {
            $error = $this->errors->createError($requestException, $url);
            return response()->json([
                                        'message' => $error,
                                    ], 500);
        }
        return false;
    }

    public function postData($url, $data)
    {
        try {
            $data = $this->api->post($url, $data);
            if ($data['data']) {
                return $data['data'];
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, $url);
        }
        return null;
    }

    public function postStatusData($url, $data): ?bool
    {
        try {
            $data = $this->api->post($url, $data);
            if ($data['data']) {
                return true;
            }
        } catch (RequestException $requestException) {
            $this->errors->createError($requestException, $url);
        }
        return null;
    }

    public function getStatusServer(): ?array
    {
        $data = $this->getData('/server/status');
        if ($data) {
            $header_class = match (mb_strtolower($data['status'])) {
                'on' => 'btn-success',
                'off' => 'btn-danger',
                default => 'btn-secondary'
            };
            $card_class = match (mb_strtolower($data['status'])) {
                'on' => 'text-bg-success',
                'off' => 'text-bg-danger',
                default => 'text-bg-secondary'
            };
            $state = match (mb_strtolower($data['status'])) {
                'on' => 1,
                'off' => 2,
                default => 3
            };
            return [
                'value'        => $data['status'],
                'header_class' => $header_class,
                'card_class'   => $card_class,
                'state'        => $state,
            ];
        }
        return null;
    }

    public function getUptimeServer(): ?array
    {
        $uptimeSecond = $this->getData('/server/getUptime');
        if ($uptimeSecond) {
            if ($uptimeSecond['uptime']['server'] > 0) {
                $uptimeSecond = $uptimeSecond['uptime']['server'];
                $minutes = floor((int) $uptimeSecond / 60);
                $hours = floor($minutes / 60);
                $minutes = $minutes - ($hours * 60);
                $now = Carbon::now()->subSeconds($uptimeSecond)->format('d.m.Y');
                return [
                    'timing' => $hours > 0 ? $hours . 'h ' : '' . $minutes . 'm',
                    'date'   => $now,
                    'status' => true,
                ];
            } else {
                return [
                    'timing' => null,
                    'date'   => $uptimeSecond['timestamp']['server_off'] ? Carbon::parse($uptimeSecond['timestamp']['server_off'])->format('d.m.Y h:iA') : '',
                    'status' => false,
                ];
            }
        }
        return null;
    }

    public function getInventoryTime(): ?string
    {
        $date = $this->getData('/inventory/getUpdatedTime');
        if ($date) {
            return Carbon::parse($date['updated_time'])->format('d.m.Y h:iA');
        }
        return null;
    }

    public function getDevicesData(): array
    {
        $res = $this->getData('/server/getData');
        $result = [];
        if ($res) {
            $result = [
                'summary_devices' => $res['devices'],
                'cpus'            => $res['cpus'],
                'cpus_class'      => $res['cpus'] ? $res['cpus']['Inserted'] > $res['cpus']['Powered'] ? 'text-bg-danger' : 'text-bg-success' : '',
                'faults'          => $res['faults'],
            ];
        }
        return $result;
    }

    //Провести инвентаризацию
    public function inventoryNow(): JsonResponse | bool
    {
        return $this->getStatusData('/inventory');
    }

    //Инициализировать устройства
    public function initDevices(): JsonResponse | bool
    {
        return $this->getStatusData('/control/initDevices');
    }

    public function getCpusData()
    {
        return $this->getData('/cpus/getData');
    }

    public function getActiveDevices()
    {
        return $this->getData('/devices/getActiveDevices');
    }
    public function getActiveDevicesData()
    {
        return $this->getData('/devices/getActiveDevicesData');
    }
    public function getMotherboardsData()
    {
        return $this->getData('/motherboards/getMotherboardsData');
    }

    public function getCarrierboardsData(): ?array
    {
        $data = $this->getData('/carrierboards/getCarrierBoardsData');
        $result = [];
        if ($data) {
            foreach ($data as $datum) {
                if ($datum) {
                    $result[] = (new CarrierboardResource($datum))->toArray();
                }
            }
        }
        return $result;
    }
}
