<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ReportController;

class SendMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:send-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send the monthly summary report to Telegram';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating and sending monthly report to Telegram...');

        $reportController = new ReportController();
        $reportController->generateAndSendMonthlyReport();

        $this->info('Report sent successfully!');
        return 0;
    }
}

