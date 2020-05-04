<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{


    protected $casts = [
        'permissions' => 'array'
//        'permissions' => 'object'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    public function getPermissions()
    {
        /*
        $role = Role::where('slug', 'user')->first();
        $perm = $role->permissions;

        $perm['delete-question'] = true;
        $perm['delete-answers'] = true;
        $role->permissions = $perm;
        $role->save();
        */


        // json_decode($perm, true)
        return json_decode($this->permissions, true);
    }

    public function hasAccess($permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;

    }

    private function hasPermission($permission)
    {
        return $this->permissions[$permission] ?? false;
    }
}
