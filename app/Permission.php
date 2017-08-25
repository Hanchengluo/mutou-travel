<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    public function get_roles_permissions(Role $roles)
    {
        $permissions = [];
        if (!empty($roles)) {
            foreach ($roles as $key => $role) {
                $permissions = $role->perms;
            }
        }

        return $permissions;
    }
}
