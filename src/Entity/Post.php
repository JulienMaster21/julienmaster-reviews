<?php

namespace App\Entity;

use App\Repository\PostRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string", message="The title must consist of text.")
     * @Assert\NotBlank(message="A title is required.")
     * @Assert\Length(max=255, maxMessage="The title can't be longer than 255 characters.")
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The subtitle must consist of text.")
     * @Assert\Length(max=255, maxMessage="The subtitle can't be longer than 255 characters.")
     */
    private ?string $subtitle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $publication_date;

    /**
     * @ORM\Column(type="text")
     * @Assert\Type("string", message="The post must consist of text.")
     */
    private string $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string", message="The photo filename must consist of text.")
     * @Assert\Length(max=255, maxMessage="The photo filename can't be longer than 255 characters.")
     */
    private ?string $photoFilename;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string", message="The status must consist of text.")
     * @Assert\Length(max=255, maxMessage="The status can't be longer than 255 characters.")
     * @Assert\Choice(choices={"not_published", "published", "archived"},
     *                message="{{ value }} is not a valid status. Choose one of these: {{ choices }}.")
     */
    // TODO Make this a state machine
    private string $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $user;

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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getPublicationDate(): ?DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(DateTimeInterface $publication_date): self
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTruncatedText(int $limit): ?string {

        return u($this->getText())->truncate($limit, "…", false)->toString();
    }

    public function getPhotoFilename(): ?string
    {
        return $this->photoFilename;
    }

    public function setPhotoFilename(?string $photoFilename): self
    {
        $this->photoFilename = $photoFilename;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isNotPublished(): bool {

        return u($this->status)->lower()->toString() === 'not_published';
    }

    public function isPublished(): bool {

        return u($this->status)->lower()->toString() === 'published';
    }

    public function isArchived(): bool {

        return u($this->status)->lower()->toString() === 'archived';
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
