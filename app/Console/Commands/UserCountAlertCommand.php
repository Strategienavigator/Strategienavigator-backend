<?php

namespace App\Console\Commands;

use App\Mail\AlertUserCountEmail;
use App\Models\Save;
use App\Models\SaveResource;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\BadComparisonUnitException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        $saveDataCharacterCount = intval(DB::table((new Save())->getTable(), "s")->select(DB::raw("SUM(OCTET_LENGTH(s.data)) as size"))->first("size")->size);
        $saveResourceSize = intval(DB::table((new SaveResource())->getTable(), "sr")->select(DB::raw("SUM(OCTET_LENGTH(sr.contents)) as size"))->first("size")->size);


        $userWeekThreshold = 50;
        $userOverallThreshold = 300;

        $saveWeekThreshold = 100;
        $saveOverallThreshold = 500;

        $saveSizeThreshold = pow(1024, 3); // 1 GB
        $saveResourceSizeThreshold = pow(1024, 3); // 1GB

        $sendAlertEmail =
            $userWeekThreshold < $userCountLastWeek ||
            $saveWeekThreshold < $saveCountLastWeek ||
            $userOverallThreshold < $userCountOverall ||
            $saveOverallThreshold < $saveCountOverall ||
            $saveSizeThreshold < $saveDataCharacterCount ||
            $saveResourceSizeThreshold < $saveResourceSize;

        $shouldSendEmail = !$this->option("no-mail");

        $notifyMessage = [
            "Raw data: ",
            "User count: $userCountOverall",
            "User count last week: $userCountLastWeek",
            "Save count: $saveCountOverall",
            "Save count last week: $saveCountLastWeek",
            "Save data character count: $saveDataCharacterCount",
            "Save Resource total size (Bytes): $saveResourceSize"];
        if ($sendAlertEmail) {


            $this->output->warning(array_merge(["Suspicious data found!"], $notifyMessage));
            Log::alert(implode("\n", $notifyMessage));

            if ($shouldSendEmail) {
                Mail::to(config("mail.from.address"))
                    ->send(new AlertUserCountEmail($userCountOverall, $userCountLastWeek, $saveCountOverall, $saveCountLastWeek, $saveDataCharacterCount, $saveResourceSize));
                $this->output->info("Send Email with User Count notification.");
            }

        } else {
            $this->output->info(array_merge(["No suspicious data found!"], $notifyMessage));

        }

        return 0;
    }
}
