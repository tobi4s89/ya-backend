<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

    protected $fillable = ['name'];

    public function userProperty()
    {
        return $this->belongsToMany(User::class, 'user_properties');
    }
}
