<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookManpower extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
        if (isset($filters['logbook_id'])) {
            $query->where('logbook_id',  $filters['logbook_id']);
        }
    }

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
