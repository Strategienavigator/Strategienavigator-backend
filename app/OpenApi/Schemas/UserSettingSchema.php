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

class UserSettingSchema extends SchemaFactory implements Reusable
{
    /**
     * @return Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('UserSetting')
            ->properties(
                Schema::string('setting_id')
                    ->description('Id der Einstellung'),
                Schema::string('user_id')
                    ->description('Id des Nutzer'),
                Schema::string('value')
                    ->description('Aktuell eingestellter Wert der Einstellung')
            );
    }
}
