<?php

namespace App\Entity;

use \DateTimeImmutable;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

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
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private string $text;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_uuid", referencedColumnName="uuid")
     */
    private UserInterface $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeImmutable $createdDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeImmutable $updatedDatetime;

    public function __construct(string $text, UserInterface $user)
    {
        $this->text = $text;
        $this->user = $user;
        $this->createdDateTime = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * The text content of this Post.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets the text content of this Post. The "last updated" time will be changed.
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * The {@link User} who owns this Post.
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * When this Post was first created.
     */
    public function getCreatedDateTime(): DateTimeImmutable
    {
        return $this->createdDateTime;
    }

    /**
     * When this Post was last edited. If the value is null, this Post has not been edited.
     */
    public function getUpdatedDateTime(): ?DateTimeImmutable
    {
        return $this->updatedDateTime;
    }

    /**
     * Sets the "updated" DateTime for this Post to the current date and time.
     */
    private function updateDateTime(): void
    {
        $this->updatedDateTime = new DateTimeImmutable();
    }
}
