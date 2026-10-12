<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

final class BoardColumn extends Model
{
    protected $table = 'board_columns';
    protected $primaryKey = 'column_id';

    public $timestamps = false;
    protected $guarded = [];

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'column_id')
            ->orderBy('sort_index');
    }
}
