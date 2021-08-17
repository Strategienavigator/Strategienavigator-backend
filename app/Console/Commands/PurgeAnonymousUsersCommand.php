<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PurgeAnonymousUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Does delete all user database entries, which are anonymous and had no activity for a long time';

    public static $purgedAfter;

    public static function userGetPurgedAfter(Carbon $date)
    {
        static::$purgedAfter = $date;
    }

    public static function getUserGetPurgedAfterTime(){
        return static::$purgedAfter?static::$purgedAfter:Carbon::now()->addMonth();
    }

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
        return User::whereAnonym(true)->where('last_activity', '<', static::getUserGetPurgedAfterTime())->forceDelete();
    }
}
