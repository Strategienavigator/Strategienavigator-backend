<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PurgeDeletedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:deleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Löscht alle Konten bei denen vor 30 Tagen die löschung beantragt wurde';

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
        User::withTrashed()->whereDate("deleted_at" ,'<' , Carbon::now()->subMonth())->forceDelete();
        return 0;
    }
}
