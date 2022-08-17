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

class SaveSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return AllOf::create('save')->schemas(
            SimpleSaveSchema::ref(),
            Schema::object()->properties(
                Schema::string('data')->nullable()->format('json')
                    ->description('Daten des Speicherstandes. Muss ein valider JSON-String sein'),
                Schema::array('contributors')->items(SimplestUserSchema::ref())
                    ->description('Alle Nutzer und ihre Rechte die Zugriff auf diesen Speicherstand haben'),
                Schema::array('invited')->items(SimplestUserSchema::ref())
                    ->description('Alle Nutzer und ihre Rechte, die zum Speicherstand eingeladen wurden aber nocht nicht angenommen oder abgelehnt haben')
            )
        );
    }
}
