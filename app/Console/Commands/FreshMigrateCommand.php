<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Laravel\Passport\Client;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Kommando, welches die Datenbank neu migriert und dabei die Oauth-Clients nicht löscht
 */
class FreshMigrateCommand extends Command
{
    /**
     * Name des Kommandos
     *
     * @var string
     */
    protected $signature = 'migrate:persistClients';

    /**
     * Beschreibungd des Kommandos
     *
     * @var string
     */
    protected $description = 'Does run migrate:fresh --seed but persists the oauth-clients';

    /**
     * Führt das Kommando aus
     */
    public function handle()
    {

        $clients = Client::all();

        Artisan::call("migrate:fresh", ["--seed"=>true], $this->output);

        foreach ($clients as $c) {
            $n = $c->replicate();
            $n->id = $c->id;
            $n->save();

        }
        $this->output->info("All data got refreshed and the clients did get persisted");
    }
}
