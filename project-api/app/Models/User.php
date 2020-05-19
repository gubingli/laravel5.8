<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users'; //写实际表名，防止找不到对应表
    protected $fillable = [
        'name', 'account','email', 'password','role','phone',
    ]; //白名单

    protected $hidden = [
        'password', 'remember_token',
    ]; //隐藏字段，防止关键字段泄露

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
