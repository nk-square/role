<?php

namespace Nksquare\Role;

trait HasRole {

	public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
    	$roles = explode('|',$role);

        return in_array($this->role->id,$role);
    }
}
