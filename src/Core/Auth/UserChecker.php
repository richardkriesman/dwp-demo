<?php


namespace App\Core\Auth;


use App\Domain\User\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Implements various pre-auth and post-auth checks on users.
 *
 * @package App\Security
 */
class UserChecker implements UserCheckerInterface
{

    /**
     * @inheritDoc
     */
    public function checkPreAuth(UserInterface $user)
    {
        // nothing to do here
    }

    /**
     * @inheritDoc
     */
    public function checkPostAuth(UserInterface $user)
    {
        if (!($user instanceof User)) { // this shouldn't ever be the case, but check just to be safe
            return;
        }

        // don't allow login if account is disabled
        if ($user->isDisabled()) {
            throw new CustomUserMessageAccountStatusException('Your account has been disabled.');
        }
    }
}