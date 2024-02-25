<?php

namespace App\Models;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password', 'role'
    ];

    public function coaches()
    {
        return $this->hasMany(Coach::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function isAdmin()
    {
        return $this->role === 'administrator';
    }

    use HasFactory;
}
