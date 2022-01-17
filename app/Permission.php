<?php

namespace App;

use Spatie\Permission\Models\Permission as SpatiePermission;


class Permission extends SpatiePermission
{
    protected $fillable = ['module_id', 'action', 'name', 'display_name', 'guard_name'];

    public function modules()
    {
        return $this->belongsTo(Permission::class);
    }

}
