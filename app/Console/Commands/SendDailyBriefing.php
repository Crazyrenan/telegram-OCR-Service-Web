<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DailyBriefingController;

class SendDailyBriefing extends Command
{
    /**
     * The name and signature of the console command.
     * The optional {date} argument allows for manual testing.
     *
     * @var string
     */
    protected $signature = 'briefing:send-daily {date? : The date to run the briefing for, in Y-m-d format.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send the daily briefing report to Telegram';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->argument('date');

        if ($date) {
            $this->info("Generating and sending the daily briefing for the date: {$date}...");
        } else {
            $this->info('Generating and sending the daily briefing...');
        }

        $briefingController = new DailyBriefingController();
        // Pass the optional date to the controller method
        $briefingController->generateBriefing($date);

        $this->info('Daily briefing sent successfully!');
        return 0;
    }
}

