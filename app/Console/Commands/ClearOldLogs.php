<?php

namespace App\Console\Commands;

use App\Jobs\DropTmpFiles;
use App\Models\TmpPhoto;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Errors\Models\Errors;

class ClearOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:clear-old-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Очистка старых логов ошибок';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Выбираем устаревшие временные фото');

        // Получаем фото, которые являются временными уже больше 5 часов
        $date = Carbon::now()->subDays(30);
        $old_logs = (new Errors())->where('created_at', '<', $date)->get();
        foreach ($old_logs as $log) {
            $log?->delete();
        }

        $this->info('Выполнено');
    }
}
