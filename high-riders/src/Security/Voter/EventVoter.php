<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class EventVoter extends Voter
{
    // these strings are just invented: you can use anything
    const EVENT_EDIT = 'EVENT_EDIT';
    const EVENT_DELETE = 'EVENT_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::EVENT_EDIT, self::EVENT_DELETE])) {
            return false;
        }

        // only vote on `spot` objects
        if (!$subject instanceof Event) {
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
        /** @var Event $event */
        $event = $subject;

        switch ($attribute) {
           case self::EVENT_EDIT:
               return $this->canEdit($event, $user);
           case self::EVENT_DELETE:
               return $this->canDelete($event, $user);
       }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Event $event, User $user): bool
    {
          // this assumes that the event object has a `getOwner()` method
          if ($user === $event->getAuthor()) {
            return true;
        }

        // $roles = $event->getAuthor()->getRoles();
        // //  dd($roles);
        // if (count($roles) == 1 && $roles[0] == 'ROLE_USER') {
        //     return true;
        // }
        
        return false;
    }

    private function canDelete(Event $event, User $user): bool
    {
          // this assumes that the event object has a `getOwner()` method
          if ($user === $event->getAuthor()) {
            return true;
        }

        // $roles = $event->getAuthor()->getRoles();
        // //  dd($roles);
        // if (count($roles) == 1 && $roles[0] == 'ROLE_USER') {
        //     return true;
        // }
        
        return false;
    }
}
