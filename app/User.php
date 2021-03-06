<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'user_properties')->withTimestamps()->withPivot(['position', 'required']);
    }
}
