<?php

namespace User\Auth;

use Cake\Auth\BaseAuthorize;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;

/**
 * Class RolesAuthorize
 *
 * @package User\Auth
 */
class RolesAuthorize extends BaseAuthorize
{
    /**
     * Constructor
     *
     * @param ComponentRegistry $registry The component registry
     * @param array $config Adapter configuration
     */
    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        parent::__construct($registry, $config);
    }

    /**
     * Authorize user for request
     *
     * @param array $user Current authenticated user
     * @param \Cake\Network\Request $request Request instance.
     * @return bool|null|void
     */
    public function authorize($user, Request $request)
    {
        //@TODO Implemented RolesAuthorize::authorize() method
        /*
        $modelName = 'Users';
        $modelId = $user['id'];

        $controllerPermissions = [];
        $controller = $this->_registry->getController();
        if ($controller && isset($controller->permissions)) {
            $controllerPermissions = $controller->permissions;
        }

        $Rbac = $this->_registry->get('Rbac');
        $_user = $Rbac->getUser($modelName, $modelId);
        $_roles = $Rbac->getUserRoles($modelName, $modelId);
        $_permissions = $Rbac->getUserPermissions($modelName, $modelId);
        */
    }
}
