<?php

namespace App\OpenApi\RequestBodies;


use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class StoreInvitationLinkRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('invitation_link_create')
            ->description('Einladungslinks Daten')
            ->content(
                MediaType::json()->schema(
                    Schema::object()
                        ->required('save_id', 'permission')
                        ->properties(
                            Schema::string('expiry_date')->format(Schema::FORMAT_DATE)->nullable()
                                ->description('Datum an dem der Einladungslink abläuft. Läuft nicht ab, wenn null oder nichts übergeben wird'),
                            Schema::integer('permission')->example(0)->enum(0, 1)
                                ->description('echte die die geteilte person besitzt. 0: Leserechte \t 1: Schreib- und Leserechte'),
                            Schema::integer('save_id')->example(21)
                                ->description('id des Speichstands, für das der Einladungslink gelten soll'),
                        )
                )
            );
    }
}
