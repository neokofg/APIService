<?php

namespace App\Console;

use App\Models\Product;
use App\Models\UserProductRent;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $rents = UserProductRent::where('rent_end_date', '<' ,Carbon::now()->format('Y-m-d H:i:s'))->get();
            foreach($rents as $rent) {
                $rent->delete();
            }
        })->everyMinute()->name('Rent checker')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
