<?php

declare(strict_types=1);

namespace Modules\Errors\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Modules\Api\Api;
use Modules\Errors\Models\Errors;

class ErrorsServices
{
    public function createError(RequestException $requestException, array | string $data = []): string
    {
        $error = json_decode($requestException->response->body());
        $text = property_exists($error, 'errors') ? $error->errors->message : ($error->detail ?? '');
        if (is_array($data) && ! empty($data)) {
            (new Errors())->create(
                [
                    'value' => $data[0],
                    'name'  => $data[1],
                    'logs'  => $text,
                ]
            );
        } else {
            Log::warning('Api method "' . $data . '" with error: ' . $text);
        }
        return $text;
    }
}
