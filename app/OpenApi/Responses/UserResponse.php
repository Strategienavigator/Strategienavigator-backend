<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\UserSchema;
use App\OpenApi\Schemas\SimpleUserSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UserResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Erfolgreich')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        OneOf::create('data')->schemas(
                            UserSchema::ref(),
                            SimpleUserSchema::ref()
                        )
                    )
                )
            );
    }
}
