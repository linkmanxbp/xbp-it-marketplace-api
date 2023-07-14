<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\SearchProvider;

#[ApiResource(
    shortName: 'Search',
    operations: [
        new GetCollection(
            uriTemplate: '/search',
            description: self::DESCRIPTION,
            provider: SearchProvider::class,
            openapiContext: [
                'summary' => self::DESCRIPTION,
                'parameters' => [
                    [
                        'name' => 'type',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                        'enum' => ['mission','profile'],
                        'required' => true,
                        'description' => 'Ad type'
                    ],                    
                    [
                        'name' => 'query',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                        'required' => true,
                        'description' => 'The search query'
                    ]
                ],
                // TODO
                // 'responses' => [
                //     '200' => [
                //         'description' => 'OK',
                //         'content' => [
                //             'application/json' => [
                //                 'schema' => [
                //                     'type' => 'integer',
                //                     'example' => 3
                //                 ]
                //             ]
                //         ]
                //     ]
                // ]
            ]
        ),
    ]
)]
final class SearchResource
{
    final public const DESCRIPTION = 'Search for ads';

    public int $id;

    public string $title;
}