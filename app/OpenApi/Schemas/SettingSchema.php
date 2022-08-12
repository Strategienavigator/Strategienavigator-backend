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

class SettingSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('setting')
            ->properties(
                Schema::integer('id')
                    ->description('Id der Einstellung'),
                Schema::string('name')
                    ->description('Name der Einstellung'),
                Schema::string('description')
                    ->description('Beschreibung der Einstellung'),
                Schema::string('type')
                    ->description('Art der Einstellung'),
                Schema::string('extras')->nullable()
                    ->description('Extra Daten die sich für jeden Einstellungstyp in der Struktur unterscheiden können. Muss ein valider JSON-String sein'),
                Schema::string('default')
                    ->description('Standardwert für diese Einstellung'),

            );
    }
}
