<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpmData extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['date'])) {
            $query->where('date', 'like', '%' . $filters['date'] . '%');
        }
        if (isset($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }
        if (isset($filters['ppm_id'])) {
            $query->where('ppm_id', $filters['ppm_id']);
        }
    }

    public function getFileAttribute($value)
    {
        if ($value && file_exists(public_path('assets/file/ppm/' . $value))) {
            return asset('assets/file/ppm/' . $value);
        } else {
            return null;
        }
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function ppm()
    {
        return $this->belongsTo(Ppm::class);
    }
}
