<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\MissionRepository;
use App\Repository\ProfileRepository;

class SearchProvider implements ProviderInterface
{
    public function __construct(
        private MissionRepository $missionRepository,
        private ProfileRepository $profileRepository
    ) {

    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($context['filters']['type'] == 'profile')
            return $this->profileRepository->findEasy($context['filters']['query']);
        else
            return $this->missionRepository->findEasy($context['filters']['query']);
    }
}