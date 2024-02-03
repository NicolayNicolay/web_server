<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Temperatures\Services\TemperaturesApiService;

class GetTemperatureData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:get-temperature-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение текущих температур основных составляющих';

    /**
     * Execute the console command.
     */
    public function handle(TemperaturesApiService $service): void
    {
        $service->getMainData();
        $service->getPsusData();
        $service->getCpuData();
        $service->getControllerData();
        $service->getSwitchData();
    }
}
