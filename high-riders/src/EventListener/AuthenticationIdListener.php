<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @param AuthenticationSuccessEvent $event
 */
class AuthenticationIdListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

    //    dd($user instanceof UserInterface);

        if (!$user instanceof User) {
            return;
        }
        
            $data['data'] = array(
        'user_pseudo' => $user->getPseudo(),
        'user_id' => $user->getId(),
        );
        
        $event->setData($data);
    }
}