<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

final class Card extends Model
{
    protected $table = 'cards';
    protected $primaryKey = 'card_id';

    const CREATED_AT = 'created_datetime';
    const UPDATED_AT = 'updated_datetime';

    protected $guarded = [];
    protected $casts = ['is_archived' => 'boolean'];

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function column()
    {
        return $this->belongsTo(BoardColumn::class, 'column_id');
    }
}
