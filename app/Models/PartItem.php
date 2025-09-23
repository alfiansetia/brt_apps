<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartItem extends Model
{
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['type'])) {
            $query->where('type',  $filters['type']);
        }
        if (isset($filters['part_id'])) {
            $query->where('part_id',  $filters['part_id']);
        }
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function imagepath()
    {
        $val = $this->getRawOriginal('image');
        if ($val && file_exists(public_path('assets/img/part/' . $val))) {
            return public_path('assets/img/part/' . $val);
        } else {
            return public_path('assets/img/noimage.jpg');
        }
    }

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('assets/img/part/' . $value))) {
            return asset('assets/img/part/' . $value);
        } else {
            return asset('assets/img/noimage.jpg');
        }
    }
}
