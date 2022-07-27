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

class PaginationMetaSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Pagination')
            ->properties(
                Schema::object('links')->properties(
                    Schema::string('first')
                        ->description('link to first page of pagination'),
                    Schema::string('last')
                        ->description('link to last page of pagination'),
                    Schema::string('prev')->nullable()
                        ->description('link to previous page of pagination'),
                    Schema::string('next')->nullable()
                        ->description('link to next page of pagination')
                ),
                Schema::object('meta')->properties(
                    Schema::integer('current_page')
                        ->example(2),
                    Schema::integer('from')->example(15)
                        ->description('index of first entry of this page'),
                    Schema::integer('last_page')->example(3),
                    Schema::integer('path')
                        ->description('link to base page of this pagination'),
                    Schema::integer('per_page')->example(15)
                        ->description('Anzahl der ')


                )
            );
    }
}
