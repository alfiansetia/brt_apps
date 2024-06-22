<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['pool_id'])) {
            $query->where('pool_id', $filters['pool_id']);
        }
        if (isset($filters['code'])) {
            $query->where('code', 'like', '%' . $filters['code'] . '%');
        }
        if (isset($filters['type'])) {
            $query->where('type',  $filters['type']);
        }
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
