<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\UserSchema;
use App\OpenApi\Schemas\InvitationLinkSchema;
use App\OpenApi\Schemas\PaginationMetaSchema;
use App\OpenApi\Schemas\SimpleUserSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class InvitationLinkListResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Erfolgreich')->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    AllOf::create()->schemas(
                        PaginationMetaSchema::ref(),
                        Schema::object()->properties(
                            Schema::array('data')->items(
                                InvitationLinkSchema::ref()
                            )
                        )
                    )
                )
            )
        );
    }
}
