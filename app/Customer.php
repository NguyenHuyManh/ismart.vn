<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public function setBirthDayAttribute($value)
    {
        $this->attributes['birth_day'] = date('Y-m-d', strtotime($value));
    }

    public function getBirthDayAttribute()
    {
        return date('d-m-Y', strtotime($this->attributes['birth_day']));
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
