<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

/**
 * @param AuthenticationSuccessEvent $event
 */
class AuthenticationIdListener
{
    // this method allows to inject the pseudo and id information in the header of the json response
    //  requested on the front side during the conexion
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

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