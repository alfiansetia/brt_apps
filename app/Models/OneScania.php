<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OneScania extends Model
{
    protected $guarded = ['id'];


    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
    }
}
