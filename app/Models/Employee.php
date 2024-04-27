<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'zip_code',
        'date_of_birth',
        'date_hired',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city->name . ', ' . $this->state->name . ', ' . $this->country->name;
    }
    
}
