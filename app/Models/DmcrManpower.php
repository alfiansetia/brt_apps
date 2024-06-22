<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DmcrManpower extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
        if (isset($filters['dmcr_id'])) {
            $query->where('dmcr_id',  $filters['dmcr_id']);
        }
    }

    public function dmcr()
    {
        return $this->belongsTo(Dmcr::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
