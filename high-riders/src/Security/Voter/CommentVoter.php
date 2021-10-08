<?php

namespace App\Security\Voter;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CommentVoter extends Voter
{
    // these strings are just invented: you can use anything
    const COMMENT_EDIT = 'COMMENT_EDIT';
    const COMMENT_DELETE = 'COMMENT_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::COMMENT_EDIT, self::COMMENT_DELETE])) {
            return false;
        }

        // only vote on `spot` objects
        if (!$subject instanceof Comment) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        //  dd($user);
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // you know $subject is a comment object, thanks to `supports()`
        /** @var Comment $comment */
        $comment = $subject;

        switch ($attribute) {
           case self::COMMENT_EDIT:
               return $this->canEdit($comment, $user);
           case self::COMMENT_DELETE:
               return $this->canDelete($comment, $user);
       }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Comment $comment, User $user): bool
    {
          // this assumes that the comment object has a `getOwner()` method
          if ($user === $comment->getUser()) {
            return true;
        }

        // $roles = $event->getAuthor()->getRoles();
        // //  dd($roles);
        // if (count($roles) == 1 && $roles[0] == 'ROLE_USER') {
        //     return true;
        // }
        
        return false;
    }

    private function canDelete(Comment $comment, User $user): bool
    {
          // this assumes that the comment object has a `getOwner()` method
          if ($user === $comment->getUser()) {
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
