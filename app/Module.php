<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'display_name', 'status'];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

}
