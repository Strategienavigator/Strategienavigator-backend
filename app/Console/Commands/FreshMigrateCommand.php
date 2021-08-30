<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
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

        $success = false;
        $tries = 0;
        $MAX_TRIES = 5;

        while(!$success && $tries++ < $MAX_TRIES){

            try {
                Artisan::call("migrate:fresh", ["--seed"=>true], $this->output);
                $success = true;
            }catch (QueryException $e){
                $mes = "Migration konnte nicht abgeschlossen werden, Versuch " . $tries . " von " . $MAX_TRIES;
                if($tries == $MAX_TRIES){
                    $mes .= "\n Es wird abgebrochen";
                }
                $this->getOutput()->error($mes);

            }
        }



        foreach ($clients as $c) {
            $n = $c->replicate();
            $n->id = $c->id;
            $n->save();

        }
        $this->output->info("All data got refreshed and the clients did get persisted");
    }
}
