<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
#[ApiResource]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\OneToMany(mappedBy: 'response', targetEntity: ResponseUser::class)]
    private Collection $responseUsers;

    #[ORM\OneToMany(mappedBy: 'response', targetEntity: Message::class)]
    private Collection $messages;

    public function __construct()
    {
        $this->responseUsers = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, ResponseUser>
     */
    public function getResponseUsers(): Collection
    {
        return $this->responseUsers;
    }

    public function addResponseUser(ResponseUser $responseUser): static
    {
        if (!$this->responseUsers->contains($responseUser)) {
            $this->responseUsers->add($responseUser);
            $responseUser->setResponse($this);
        }

        return $this;
    }

    public function removeResponseUser(ResponseUser $responseUser): static
    {
        if ($this->responseUsers->removeElement($responseUser)) {
            // set the owning side to null (unless already changed)
            if ($responseUser->getResponse() === $this) {
                $responseUser->setResponse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setResponse($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getResponse() === $this) {
                $message->setResponse(null);
            }
        }

        return $this;
    }
}
