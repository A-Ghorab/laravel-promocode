<?php

namespace AGhorab\LaravelPromocode\Tests\MockModels;

use AGhorab\LaravelPromocode\Traits\HasPromocode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasPromocode, HasFactory;

    protected $table = 'users';

    protected $guarded = [];

    protected static function newFactory()
    {
        return new UserFactory();
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['id'];
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    public function getRememberToken()
    {
        return 'token';
    }

    public function setRememberToken($value)
    {

    }

    public function getRememberTokenName()
    {
        return 'tokenName';
    }
}
