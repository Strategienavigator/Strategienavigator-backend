<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class SimpleSaveSchema extends SchemaFactory implements Reusable
{
    /**
     * @return Schema
     */
    public function build(): SchemaContract
    {
        return AllOf::create('simple_save')
            ->schemas(
                SimplerSaveSchema::ref(),
                Schema::object()
                    ->properties(
                        Schema::integer('locked_by')->nullable()
                            ->description('id eines Nutzers der diesen Speicherstand sperrt. Null wenn niemend diesen Speicherstand sperrt'),
                        Schema::string('description')
                            ->description('Beschreibung des Speicherstands'),
                        Schema::string('last_locked')->nullable()->format(Schema::FORMAT_DATE)
                            ->description('Zeitpunkt an dem der Speicherstand zuletzt gesperrt wurde (kann auch nicht null sein, wenn der Speicherstand gerade nicht gesperrt ist). Null wenn der Speicherstsandnie noch nie gesperrt wurde'),
                        Schema::boolean('owner_deleting')
                            ->description('gibt an ob der Speicherstand nach den 30 Tagen gelöscht wird'),
                        Schema::string('updated_at')->format(Schema::FORMAT_DATE)
                            ->description('Zeitpunkt an dem dieser Speicherstand zuletzt bearbeitet wurde'),
                        Schema::string('created_at')->format(Schema::FORMAT_DATE)
                            ->description('Zeitpunkt an dem dieser Speicherstand erstellt wurde'),
                        Schema::string('deleted_at')->format(Schema::FORMAT_DATE)->nullable()
                            ->description('Zeitpunkt an dem ein Nutzer die Löschung des Speicherstandes in auftrag gegeben hat. Null wenn dieser Speicherstand nicht gelöscht wurde')
                    )
            );
    }
}
