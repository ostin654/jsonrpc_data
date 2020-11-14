<?php

namespace App\Entity;

use App\Repository\PageDataRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=PageDataRepository::class)
 */
class PageData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @SerializedName("name")
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     * @SerializedName("notes")
     */
    private string $notes;

    /**
     * @ORM\Column(type="string", length=36)
     * @SerializedName("page_uid")
     */
    private string $pageUid;

    /**
     * @ORM\Column(type="datetime")
     * @SerializedName("created_at")
     */
    private \DateTimeInterface $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getPageUid(): ?string
    {
        return $this->pageUid;
    }

    public function setPageUid(string $pageUid): self
    {
        $this->pageUid = $pageUid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
