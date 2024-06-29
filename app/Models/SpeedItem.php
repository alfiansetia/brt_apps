<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeedItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
    }

    public function sped()
    {
        return $this->belongsTo(Speed::class);
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
