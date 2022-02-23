<?php

namespace App\Console\Commands;

use App\Mail\AlertUserCountEmail;
use App\Models\Save;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\BadComparisonUnitException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserCountAlertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:userCount {--no-mail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prüft wie viele User in den letzten 24 Stunden hinzugekommen sind und wie
     viele insgesamt existieren und schickt ein E-Mail falls es Gewisse Schwellenwerte überschreitet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $userCountLastWeek = User::withTrashed()->whereDate("created_at", ">", Carbon::now()->subWeek())->count();

        $userCountOverall = User::withTrashed()->count();

        $saveCountLastWeek = Save::withTrashed()->whereDate("created_at", ">", Carbon::now()->subWeek())->count();

        $saveCountOverall = Save::withTrashed()->count();


        $userWeekThreshold = 50;
        $userOverallThreshold = 300;

        $saveWeekThreshold = 100;
        $saveOverallThreshold = 500;

        $sendAlertEmail =
            $userWeekThreshold < $userCountLastWeek ||
            $saveWeekThreshold < $saveCountLastWeek ||
            $userOverallThreshold < $userCountOverall ||
            $saveOverallThreshold < $saveCountOverall;

        $shouldSendEmail = !$this->option("no-mail");

        if ($sendAlertEmail) {
            $notifyMessage = [
                "Suspicious User/Save count detected:",
                "Usercount: $userCountOverall",
                "Usercount last week: $userCountLastWeek",
                "Savecount: $saveCountOverall",
                "Savecount last week: $saveCountLastWeek"];

            $this->output->info($notifyMessage);
            Log::alert(implode("\n",$notifyMessage));

            if ($shouldSendEmail) {
                Mail::to(config("mail.from.address"))
                    ->send(new AlertUserCountEmail($userCountOverall, $userCountLastWeek, $saveCountOverall, $saveCountLastWeek));
                $this->output->info("Send Email with User Count notification.");
            }

        } else {
            $this->output->info("User Count doesn't look suspicious.");

        }

        return 0;
    }
}
