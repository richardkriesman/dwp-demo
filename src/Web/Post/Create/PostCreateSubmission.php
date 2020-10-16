<?php

namespace App\Web\Post\Create;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Represents a submission from {@link PostCreateFormType}, which is used to create a new {@link Post}.
 *
 * @package App\Form\Post
 */
final class PostCreateSubmission
{

    /**
     * @Assert\NotBlank(message="Type a message...")
     * @Assert\Length(max="500")
     * @var string
     */
    public string $text;

}