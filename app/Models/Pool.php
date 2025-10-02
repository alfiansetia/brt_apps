<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
    }

    public function getImageAttribute($value)
    {
        if ($value && file_exists(storage_path('/app/public/img/pool/' . $value))) {
            return asset('storage/img/pool/' . $value);
        } else {
            return asset('assets/img/noimage.jpg');
        }
    }
}
