<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Wish;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class WishVoter extends Voter
{
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Wish;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /**
         * @var Wish $wish
         */
        $wish = $subject;
        /**
         * @var User $user
         */

        return match ($attribute) {
            self::EDIT => $this->canEdit($wish, $user),
            self::DELETE => $this->canDelete($wish, $user),
            default => false
        };
    }

    private function canEdit(Wish $wish, User $user): bool
    {
        $isNotModerated = $wish->isIsModerated() == false;
        $isOwnerOfWish = $wish->getUser() && $wish->getUser()->getId() == $user->getId();

        return $isNotModerated && $isOwnerOfWish;
    }

    private function canDelete(Wish $wish, User $user): bool
    {
        return $this->canEdit($wish, $user);
    }
}
