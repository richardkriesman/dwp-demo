<?php


namespace App\Core\Post;


use App\Domain\Post;
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
     * Gets an array containing all {@link Post} instances.
     *
     * @return Post[]
     */
    public function getAll();

}