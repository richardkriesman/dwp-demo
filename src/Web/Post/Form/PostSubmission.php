<?php

namespace App\Web\Post\Form;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Represents a submission from {@link PostFormType}, which is used to create a new {@link Post}.
 *
 * @package App\Form\Post
 */
final class PostSubmission
{

    /**
     * @Assert\NotBlank(message="Choose a title for your post.")
     * @Assert\Length(max="100")
     * @var string
     */
    public string $title;

    /**
     * @Assert\NotBlank(message="What do you want to say?")
     * @var string
     */
    public string $text;

}