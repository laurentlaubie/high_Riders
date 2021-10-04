<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{
    // these strings are just invented: you can use anything
    const USER_EDIT = 'USER_EDIT';
    const USER_DELETE = 'USER_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::USER_EDIT, self::USER_DELETE])) {
            return false;
        }

        // only vote on `spot` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // dd($user);
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // you know $subject is a event object, thanks to `supports()`
        /** @var User $event */
        $userObjet = $subject;

        switch ($attribute) {
           case self::USER_EDIT:
               return $this->canEdit($userObjet, $user);
           case self::USER_DELETE:
               return $this->canDelete($userObjet, $user);
       }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(User $userObjet, User $user): bool
    {
        // dd($user);

          // this assumes that the event object has a `getOwner()` method
          if ($user === $userObjet) {
            return true;
        }

        // $roles = $userObjet->getRoles();
        // //  dd($roles);
        // if (count($roles) == 1 && $roles[0] == 'ROLE_USER') {
        //     return true;
        // }
        
        return false;
    }

    private function canDelete(User $userObjet, User $user): bool
    {
          // this assumes that the event object has a `getOwner()` method
          if ($user === $userObjet) {
            return true;
        }

        // $roles = $userObjet->getRoles();
        // //  dd($roles);
        // if (count($roles) == 1 && $roles[0] == 'ROLE_USER') {
        //     return true;
        // }
        
        return false;
    }
}
