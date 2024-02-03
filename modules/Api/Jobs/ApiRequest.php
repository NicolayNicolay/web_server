<?php

declare(strict_types=1);

namespace Modules\Api\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Api\Api;


class ApiRequest implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected string $url;
    protected string $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url, string $type = 'get')
    {
        $this->url = $url;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws RequestException
     */
    public function handle(): void
    {
        match ($this->type) {
            'get' => (new Api())->get($this->url),
            'post' => (new Api())->post($this->url),
        };
    }
}
