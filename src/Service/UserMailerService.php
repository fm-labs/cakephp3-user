<?php

namespace User\Service;

use Cake\Core\InstanceConfigTrait;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Log\Log;
use Cake\Mailer\Email;
use User\Mailer\UserMailer;
use User\Mailer\UserMailerTrait;

/**
 * Class UserMailerService
 *
 * @package User\Event
 * @todo error handling: catch mailer exceptions.
 */
class UserMailerService implements EventListenerInterface
{
    use InstanceConfigTrait;
    use UserMailerTrait;

    protected $_defaultConfig = [
        'mailerClass' => '\\User\\Mailer\\UserMailer',
        /*'emailProfile' => 'default'*/
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config($config);
        $this->_mailerClass = $this->_config['mailerClass'];
    }

    public function sendEmail($action, $args = [])
    {
        try {
            $mailer = $this->getMailer();
            $mailer->send($action, $args);
        } catch (\Exception $ex) {
            Log::error('UserMailerServer::sendEmail: ' . $ex->getMessage());
        }
    }

    /**
     * @param Event $event
     * @return void
     */
    public function onRegister(Event $event)
    {
        $this->sendEmail('userRegistration', [$event->subject()]);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function onActivate(Event $event)
    {
        $this->sendEmail('userActivation', [$event->subject()]);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function onNewLogin(Event $event)
    {
        $this->sendEmail('newLogin', [$event->subject()]);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function onPasswordForgotten(Event $event)
    {
        $this->sendEmail('passwordForgotten', [$event->subject()]);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function onPasswordReset(Event $event)
    {
        $this->sendEmail('passwordReset', [$event->subject()]);
    }

    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'User.Model.User.register'          => 'onRegister',
            'User.Model.User.activate'          => 'onActivate',
            'User.Model.User.passwordForgotten' => 'onPasswordForgotten',
            'User.Model.User.passwordReset'     => 'onPasswordReset',
            'User.Model.User.newLogin'          => 'onNewLogin'
        ];
    }
}
