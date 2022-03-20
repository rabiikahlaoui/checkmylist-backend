<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /** @var bool */
    public $timestamps = true;

    /** @var array */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /** @var array */
    protected $hidden = [
        'password',
    ];

    /** @var array */
    protected $visible = [
        'id',
        'name',
        'email',
    ];

    /** @var array */
    protected $sortable = [
        'id',
        'name',
        'email',
        'created_at',
    ];

    /** @var array */
    protected $searchable = [
        'name',
    ];

    /** @var array */
    protected $encrypted = [
        'name',
        'email'
    ];
}

