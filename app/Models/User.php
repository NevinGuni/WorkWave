<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'username', 'password', 'role',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'user_id');
    }
}