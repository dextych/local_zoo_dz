<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

final class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    const CREATED_AT = 'created_datetime';
    const UPDATED_AT = 'updated_datetime';

    protected $guarded = [];
    protected $hidden = ['password_hash'];

    public function boards()
    {
        return $this->hasMany(Board::class, 'owner_user_id');
    }
}
