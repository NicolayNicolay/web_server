<?php

declare(strict_types=1);

namespace Modules\Api;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Api
{
    protected string $token = '';
    protected int $timeout = 0;

    public function __construct()
    {
        $this->setBearer();
    }

    public function setBearer(): static
    {
        $this->token = config('api.bearer');
        return $this;
    }

    public function getHost(): string
    {
        $host = config('api.host');
        if (! empty($host)) {
            return $host;
        }
        return '';
    }

    /**
     * @throws RequestException
     * @throws Exception
     */
    public function sendRequest(string $method, string $requestMethod = 'GET', array $params = []): ?array
    {
        $apiUrl = $this->getHost() . config('api.path');
        $headers = ['Authorization' => 'Bearer ' . $this->token];
        $httpRequest = Http::asJson()->withHeaders($headers);
        if ($this->timeout != 0) {
            $httpRequest->timeout($this->timeout);
        }
        $request = app(Request::class);
        if ($requestMethod === 'GET') {
            if ($request->has('debug')) {
                echo '<pre>';
                $httpRequest = $httpRequest->withOptions(['debug' => true])->asJson()->get($apiUrl . $method, $params);
            } else {
                $httpRequest = $httpRequest->get($apiUrl . $method, $params);
            }
        } else {
            if ($request->has('debug')) {
                echo '<pre>';
                $httpRequest = $httpRequest->withOptions(['debug' => true])->asJson()->post($apiUrl . $method, ['data' => $params]);
            } else {
                $httpRequest = $httpRequest->asJson()->post($apiUrl . $method, ['data' => $params]);
            }
        }
        return $httpRequest->throw()->json();
    }

    /**
     * @throws RequestException
     */
    public function post(string $method, array $params = [], int $timeout = 0): ?array
    {
        if ($timeout != 0) {
            $this->timeout = $timeout;
        }
        return $this->sendRequest($method, 'POST', $params);
    }

    /**
     * @throws RequestException
     */
    public function get(string $method, array $params = [], int $timeout = 0): ?array
    {
        if ($timeout != 0) {
            $this->timeout = $timeout;
        }
        return $this->sendRequest($method, 'GET', $params);
    }
}
