<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\PhotoAlbum\Photo;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class PhotoVoter extends Voter
{
    public const string DELETE = 'PHOTO_DELETE';

    /**
     * Determines if the attribute and subject are supported by this voter.
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE && $subject instanceof Photo;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token. It is safe to assume that
     * attribute and subject already passed the "supports()" method check.
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        // we can assume that the subject is a Photo at this point
        /** @var $subject Photo */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // checking rules and voting by returning bool value
        if ($attribute === self::DELETE) {
            return $subject->getUploader()?->getUserIdentifier() === $user->getUserIdentifier();
        }

        return false;
    }
}
