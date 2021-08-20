<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\Client;
use Symfony\Component\Console\Output\BufferedOutput;

class freshMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:persistClients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Does run migrate:fresh --seed but persists the oauth-clients';

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
     */
    public function handle()
    {

        $clients = Client::all();

        \Artisan::call("migrate:fresh", ["--seed"=>true], $this->output);

        foreach ($clients as $c) {
            $n = $c->replicate();
            $n->id = $c->id;
            $n->save();

        }
        $this->output->info("All data got refreshed and the clients did get persisted");
    }
}
