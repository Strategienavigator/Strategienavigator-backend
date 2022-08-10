<?php

namespace App\OpenApi\Responses;

use App\Models\InvitationLink;
use App\OpenApi\Schemas\CompleteUserSchema;
use App\OpenApi\Schemas\InvitationLinkSchema;
use App\OpenApi\Schemas\SimpleUserSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class InvitationLinkResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        InvitationLinkSchema::ref('data')
                    )
                )
            );
    }
}
