<?php


namespace App\Core\Post;


use App\Domain\Post;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * A service for creating and managing {@link Post} instances.
 *
 * @package App\Core\Post
 */
interface PostServiceInterface
{

    /**
     * Creates a new {@link Post}.
     *
     * @param string $title Title of the Post
     * @param string $text Text content of the Post
     * @param UserInterface $user Author of the Post
     *
     * @return Post
     */
    public function create(string $title, string $text, UserInterface $user): Post;

    /**
     * Gets a {@link Post} by its ID. If no such {@link Post} exists, `null` will be returned.
     *
     * @param int $id Post ID
     *
     * @return Post|null
     */
    public function get(int $id): ?Post;

    /**
     * Gets an array containing all {@link Post} instances.
     *
     * @return Post[]
     */
    public function getAll();

}