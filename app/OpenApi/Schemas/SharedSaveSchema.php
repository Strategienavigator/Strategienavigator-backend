<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class SharedSaveSchema extends SchemaFactory
{
    /**
     *
     *
     * @return Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('shared_save')
            ->properties(
                Schema::integer('id')
                    ->description('id des SharedSave'),
                SimplestUserSchema::ref('user'),
                SimplerSaveSchema::ref('save'),
                Schema::integer('permission')->enum(0, 1, 2)
                    ->description('Rechte die die geteilte person besitzt. 0: Leserechte \t 1: Schreib- und Leserechte \t 2: Adminrechte'),
                Schema::boolean('accepted')
                    ->description('Ob der eingeladene Nutzer die Einladung angenommen hat. Hat alleine keine aussagekraft darüber ob der eingeladene Nutzer Zugriff auf den Speicherstand hat'),
                Schema::boolean('declined')
                    ->description('Ob der eingeladene Nutzer die Einladung abgelehnt hat'),
                Schema::boolean('revoked')
                    ->description('Ob der einladene Nutzer die Einladung zurückgenommen hat')
            );
    }
}
