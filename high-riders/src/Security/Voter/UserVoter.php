<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['USER_EDIT', 'USER_DELETE'])
            && $subject instanceof \App\Entity\User;
        //($subject instanceof \App\Entity\User||$subject instanceof \App\Entity\Event||$subject instanceof \App\Entity\Spot);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // dd($token->getUser());
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'USER_EDIT':
                // if ($subject === $user) {
                //     return true;
                // }
                // if (in_array($user-> getUserIdentifier(), ['IS_AUTHENTICATED_FULLY'])) {
                //     return true;
                // }
                return $subject->getUserIdentifier() === $user;
                break;
            case 'USER_DELETE':
                return $subject->getUserIdentifier() === $user;

                break;
        }

        return false;
    }
}
