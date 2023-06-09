<?php

namespace App\Entities;
namespace App\Domain\CheckListContext\Entities;

use App\Repository\CheckListRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckListRepository::class)]
class CheckList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    #[Groups(['full', 'for_list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Groups(['full', 'for_list'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\DateTime]
    #[Groups(['full', 'for_list'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\DateTime]
    #[Groups(['full'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Assert\IsTrue(message: 'UpdateAt must more or equal createdAt')]
    public function checkUpdateAtMoreCreateAt(): bool
    {
        return $this->updatedAt >= $this->createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
