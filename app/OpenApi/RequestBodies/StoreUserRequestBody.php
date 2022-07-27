<?php

namespace App\OpenApi\RequestBodies;


use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class StoreUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('UserCreate')
            ->description('Nutzerdaten')
            ->content(
                MediaType::json()->schema(
                    Schema::object()
                        ->required('username', 'email', 'password')
                        ->properties(
                            Schema::string('username')->default(null),
                            Schema::string('email')->default(null),
                            Schema::string('password')->default(null),
                            Schema::integer('anonymous_id')->default(null)
                                ->description('id des anonymen users von dem alle Einstellungen und Daten übernommen werden sollen'),
                        ))
            );
    }
}
