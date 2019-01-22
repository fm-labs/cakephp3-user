<?php

namespace User\Service;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Network\Request;

/**
 * Class GoogleAuthenticatorService
 *
 * @package User\Event
 */
class GoogleAuthenticatorService implements EventListenerInterface
{

    /**
     * @param Event $event
     * @return null|array
     */
    public function onLogout(Event $event)
    {
        $event->subject()->request->session()->delete('Auth.GoogleAuth');
    }

    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'User.Auth.logout' => 'onLogout',
        ];
    }
}
