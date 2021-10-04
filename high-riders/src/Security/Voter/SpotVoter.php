<?php

namespace App\Security\Voter;

use App\Entity\Spot;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class SpotVoter extends Voter
{
    // these strings are just invented: you can use anything
    const SPOT_EDIT = 'SPOT_EDIT';
    const SPOT_DELETE = 'SPOT_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::SPOT_EDIT, self::SPOT_DELETE])) {
            return false;
        }

        // only vote on `spot` objects
        if (!$subject instanceof Spot) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // you know $subject is a spot object, thanks to `supports()`
        /** @var Spot $spot */
        $spot = $subject;

        switch ($attribute) {
           case self::SPOT_EDIT:
               return $this->canEdit($spot, $user);
           case self::SPOT_DELETE:
               return $this->canDelete($spot, $user);
       }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Spot $spot, User $user): bool
    {
        // this assumes that the spot object has a `getOwner()` method
        return $user === $spot->getAuthor();
    }

    private function canDelete(spot $spot, User $user): bool
    {
        // this assumes that the spot object has a `getOwner()` method
        return $user === $spot->getAuthor();
    }
}
