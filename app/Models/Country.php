<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'phone_code',
    ];

    public function states(): hasMany
    {
        return $this->hasMany(State::class);
    }

    public function employees(): hasMany
    {
        return $this->hasMany(Employee::class);
    }

    // public function cities(): hasManyThrough
    // {
    //     return $this->hasManyThrough(City::class, State::class);
    // }

   
    // public function departments()
    // {
    //     return $this->hasManyThrough(Department::class, Employee::class);
    // }

    // public function users()
    // {
    //     return $this->hasManyThrough(User::class, Employee::class);
    // }


}
