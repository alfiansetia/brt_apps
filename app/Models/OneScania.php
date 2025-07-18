<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OneScania extends Model
{
    protected $guarded = ['id'];


    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['number'])) {
            $query->where('number', 'like', '%' . $filters['number'] . '%');
        }
    }

    public function getFileAttribute($value)
    {
        if (!$value) {
            return null;
        }
        if ($value && file_exists(public_path('/assets/file/one_scania/' . $value))) {
            return url('assets/file/one_scania/' . $value);
        } else {
            return null;
        }
    }
}
