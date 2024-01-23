<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // use HasFactory;
    protected $fillable = ['user_name', 'first_name', 'last_name', 'email','phone', 'gender','password'];

    protected $hidden = ['password'];
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->get();
    }
    public function findUser($id)
    {
        return $this->find($id);
    }
}
