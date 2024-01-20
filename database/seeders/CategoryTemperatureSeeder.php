<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\OrderTracking\Models\PostResponse;
use Modules\Temperatures\Models\Temperatures;
use Modules\Temperatures\Models\TemperaturesCategories;

class CategoryTemperatureSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $properties = [
            [
                'name' => 'Материнская плата',
                'code' => 'motherboards',
            ],
            [
                'name' => 'Дополнительная плата',
                'code' => 'carrierboards',
            ],
            [
                'name' => 'Блок Питания',
                'code' => 'psu',
            ],
            [
                'name' => 'Центральный процессор',
                'code' => 'cpu',
            ],
            [
                'name' => 'Контроллер',
                'code' => 'controller',
            ],
            [
                'name' => 'Сетевой коммутатор',
                'code' => 'switch',
            ],
        ];
        foreach ($properties as $item) {
            (new TemperaturesCategories())->updateOrCreate(
                [
                    'code' => $item['code'],
                ],
                [
                    'code' => $item['code'],
                    'name' => $item['name'],
                ]
            );
        }
    }
}
