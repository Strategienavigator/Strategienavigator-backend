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

class PasswordResetSchema extends SchemaFactory implements Reusable
{
    /**
     * @return Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('password_reset')
            ->properties(
                Schema::integer('user_id')
                    ->description('id des Users'),
                Schema::string('expiry_date')->format(Schema::FORMAT_DATE)
                    ->description('Ablaufdatum')
            );
    }
}
