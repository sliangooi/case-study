<?php

namespace App;

use App\Helpers\DNA;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name','display_name', 'description','guard_name'];

    const SUPERADMIN = 'superadmin';
    const ADMIN = 'admin';
    const EMPLOYEE = 'employee';

    public function scopeNotSuperadmin($query)
    {
        return $query->where('name', '!=', self::SUPERADMIN);
    }


}
