<?php

namespace User\Service;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Network\Request;

/**
 * Class UserAuthService
 *
 * @package User\Event
 */
class UserAuthService implements EventListenerInterface
{

    /**
     * @param Event $event The event object
     * @return array|void
     */
    public function beforeLogin(Event $event)
    {
        $user = (isset($event->data['user'])) ? $event->data['user'] : [];

        if (empty($user)) {
            $event->data += [
                'redirect' => ['_name' => 'user:login']
            ];

            return false;
        }

        if (isset($user['is_deleted']) && $user['is_deleted'] == true) {
            $event->data['user'] = null;
            $event->data += [
                'error' => __d('user', 'This account has been deleted'),
                'redirect' => ['_name' => 'user:login']
            ];

            return false;
        }

        if (isset($user['block_enabled']) && $user['block_enabled'] == true) {
            $event->data += [
                'error' => __d('user', 'This account has been blocked'),
                'redirect' => ['_name' => 'user:login']
            ];

            return false;
        }

        if (isset($user['login_enabled']) && $user['login_enabled'] != true) {
            $event->data += [
                'error' => __d('user', 'Login to this account is not enabled'),
                'redirect' => ['_name' => 'user:login']
            ];

            return false;
        }

        if ($user['email_verification_required'] && !$user['email_verified']) {
            $event->data += [
                'error' => __d('user', 'Your account has not been verified yet'),
                'redirect' => ['_name' => 'user:activate']
            ];

            return false;
        }
    }

    /**
     * @param Event $event The event object
     * @return array|void
     */
    public function afterLogin(Event $event)
    {
        $request = (isset($event->data['request'])) ? $event->data['request'] : null;
        $user = (isset($event->data['user'])) ? $event->data['user'] : null;
        if ($user && isset($user['id'])) {
            $clientIp = $clientHostname = null;
            if ($request instanceof Request) {
                $clientIp = $request->clientIp();
                //$clientHostname = null;
            }
            $data = [
                'login_last_login_ip' => $clientIp,
                'login_last_login_host' => $clientHostname,
                'login_last_login_datetime' => new Time(),
                'login_failure_count' => 0, // reset login failure counter
            ];

            /* @var \User\Model\Entity\User $entity */
            $entity = $event->subject()->Users->get($user['id']);
            $entity->accessible(array_keys($data), true);
            $entity = $event->subject()->Users->patchEntity($entity, $data);
            if (!$event->subject()->Users->save($entity)) {
                Log::error("Failed to update user login info", ['user']);
            }

            EventManager::instance()->dispatch(new Event('User.Model.User.newLogin', $event->subject()->Users, [
                'user' => $entity,
                'data' => $data
            ]));
        }
    }

    /**
     * @param Event $event The event object
     * @return void
     */
    public function onLoginError(Event $event)
    {
        $request = $event->data['request'];
        $data = $request->data;

        if (isset($data['username'])) {
            $user = $event->subject()->Users->findByUsername($data['username'])->first();
            if ($user) {
                $user->login_failure_count++;
                $user->login_failure_datetime = new Time();

                if (!$event->subject()->Users->save($user)) {
                    Log::error("Failed to update user with login info", ['user']);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'User.Auth.beforeLogin' => 'beforeLogin',
            'User.Auth.login' => 'afterLogin',
            'User.Auth.error' => 'onLoginError',
        ];
    }
}
