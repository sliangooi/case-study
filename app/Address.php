<?php

namespace App;

use App\Helpers\DNA;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id','full_address','address','postcode','state','country'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
}
