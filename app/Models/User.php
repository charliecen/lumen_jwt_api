<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 一对多，一个用户拥有多个文章
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    /**
     * @inheritDoc
     * 获取jwt中的用户标识
     */
    public function getJWTIdentifier()
    {
//         TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    /**
     * @inheritDoc
     * 获取jwt中的用户自定义字段
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
}
