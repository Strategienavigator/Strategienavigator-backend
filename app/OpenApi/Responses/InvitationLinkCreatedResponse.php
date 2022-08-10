<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CompleteUserSchema;
use App\OpenApi\Schemas\InvitationLinkSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Header;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Link;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class InvitationLinkCreatedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::created('invitation_link_created')
            ->description('Successful response')
            ->headers(
                Header::create('Location')
                    ->description('Relativer Link zu der erstellen Ressource')
                    ->schema(Schema::string())
            )->content(MediaType::json()->schema(
                Schema::object()->properties(
                    InvitationLinkSchema::ref('data')
                )
            ));
    }
}
