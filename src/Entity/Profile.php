<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ApiResource]
#[ORM\AssociationOverrides([
    new ORM\AssociationOverride(
        name: 'user', inversedBy: "profiles"
    )
])]
class Profile extends Ad
{
}