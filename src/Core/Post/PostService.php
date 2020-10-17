<?php


namespace App\Core\Post;


use App\Domain\Post;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Concrete implementation of {@link PostServiceInterface}.
 *
 * @package App\Core\Post
 */
final class PostService implements PostServiceInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @inheritDoc
     */
    public function create(string $title, string $text, UserInterface $user): Post
    {
        $post = new Post($title, $text, $user);
        $this->em->persist($post);
        $this->em->flush();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?Post
    {
        return $this->em->getRepository(Post::class)->find($id);
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $this->em->getRepository(Post::class)->findBy([], ['id' => 'DESC']);
    }

}