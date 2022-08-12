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

class InvitationLinkSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('invitation_link')
            ->properties(
                Schema::string('expiry_date')->format(Schema::FORMAT_DATE)->nullable()
                    ->description('Datum an dem der Link abläuft. Null wenn er nie abläuft'),
                Schema::integer('permission')->enum(0, 1, 2)
                    ->description('Rechte die die geteilte person besitzt. 0: Leserechte \t 1: Schreib- und Leserechte \t 2: Adminrechte'),
                SimplerSaveSchema::ref('save'),
                Schema::string('created_at')->format(Schema::FORMAT_DATE)
                    ->description('Zeitpunkt an dem dieser Speicherstand erstellt wurde'),
                Schema::string('Token der diesen Link indentifiziert')
            );
    }
}
