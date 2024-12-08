<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $table = 'users'; 
    protected $fillable = ['name', 'email', 'password', 'coffee_points'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}