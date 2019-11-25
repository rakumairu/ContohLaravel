<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Nama Tabel
    protected $table = 'User';
    // Primary Key dari Tabel
    protected $primaryKey = 'username';
    // Deactive Remember Token
    protected $rememberTokenName = false;
    // Disable timestamps
    public $timestamps = false;
    // Disable timestamps
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
