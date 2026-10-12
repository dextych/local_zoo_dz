<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

final class Board extends Model
{
    protected $table = 'boards';
    protected $primaryKey = 'board_id';

    const CREATED_AT = 'created_datetime';
    const UPDATED_AT = 'updated_datetime';

    protected $guarded = [];
    protected $casts = ['is_public' => 'boolean'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function columns()
    {
        return $this->hasMany(BoardColumn::class, 'board_id')
            ->orderBy('ordinal_position');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'board_id');
    }
}
