<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
#[ApiResource]
#[ORM\AssociationOverrides([
    new ORM\AssociationOverride(
        name: 'user', inversedBy: "missions"
    )
])]
class Mission extends Ad
{
}