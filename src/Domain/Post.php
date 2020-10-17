<?php

namespace App\Domain;

use \DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
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
     * @ORM\Column(type="string", length=100)
     */
    private string $title;

    /**
     * @ORM\Column(type="text")
     */
    private string $text;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_uuid", referencedColumnName="uuid")
     */
    private UserInterface $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdDateTime;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $updatedDateTime = null;

    public function __construct(string $title, string $text, UserInterface $user)
    {
        $this->title = $title;
        $this->text = $text;
        $this->user = $user;
        $this->createdDateTime = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * The title of this Post.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title of this Post. The "last updated" time will be changed.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->updateDateTime();
        return $this;
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
     *
     * @param string $text
     * @return Post
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        $this->updateDateTime();
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
