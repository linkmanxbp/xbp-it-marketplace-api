<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Response $response = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'message', targetEntity: MessageUser::class, orphanRemoval: true)]
    private Collection $messageUsers;

    public function __construct()
    {
        $this->messageUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, MessageUser>
     */
    public function getMessageUsers(): Collection
    {
        return $this->messageUsers;
    }

    public function addMessageUser(MessageUser $messageUser): static
    {
        if (!$this->messageUsers->contains($messageUser)) {
            $this->messageUsers->add($messageUser);
            $messageUser->setMessage($this);
        }

        return $this;
    }

    public function removeMessageUser(MessageUser $messageUser): static
    {
        if ($this->messageUsers->removeElement($messageUser)) {
            // set the owning side to null (unless already changed)
            if ($messageUser->getMessage() === $this) {
                $messageUser->setMessage(null);
            }
        }

        return $this;
    }
}
