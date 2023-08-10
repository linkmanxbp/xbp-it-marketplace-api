<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
#[ORM\AssociationOverrides([
    new ORM\AssociationOverride(
        name: 'user',
        inversedBy: "missions"
    )
])]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(
            security: 'is_granted("ROLE_USER", object)',
            openapiContext: [
                'security' => [['bearerAuth' => []]]
            ]
        ),
        new Post(
            security: 'is_granted("ROLE_USER", object)',
            openapiContext: [
                'security' => [['bearerAuth' => []]]
            ]
        ),
        new Put(),
        new Delete(),
        new Patch()
    ]
)]
class Mission extends Ad
{
}