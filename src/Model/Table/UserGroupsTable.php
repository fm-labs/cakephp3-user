<?php
namespace User\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use User\Model\Entity\UserGroup;

/**
 * UserGroups Model
 */
class UserGroupsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_user_groups');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->hasMany('PrimaryUsers', [
            'foreignKey' => 'user_group_id',
            'className' => 'User.Users'
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'user_group_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'user_user_groups_users',
            'className' => 'User.Users'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->allowEmpty('password');

        return $validator;
    }
}
