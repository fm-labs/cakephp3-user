<?php

namespace User\Form;

use Cake\Form\Form;
use Cake\ORM\TableRegistry;
use User\Model\Entity\User;

abstract class UserForm extends Form
{

    /**
     * @var \User\Model\Table\UsersTable
     */
    public $Users;

    /**
     * @var \User\Model\Entity\User
     */
    public $user;

    public function __construct(User $user = null)
    {
        $this->Users = TableRegistry::get('User.Users');
        if ($user === null) {
            $user = $this->Users->newEntity();
        }
        $this->user = $user;
    }

    /**
     * Get user entity object
     */
    public function getUser()
    {
        return $this->user;
    }
}
