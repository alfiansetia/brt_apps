<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hmkm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['pool_id'])) {
            $query->whereRelation('unit', 'pool_id',  $filters['pool_id']);
        }
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
