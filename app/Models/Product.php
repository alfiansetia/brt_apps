<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['code'])) {
            $query->where('code', 'like', '%' . $filters['code'] . '%');
        }
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
    }
}
