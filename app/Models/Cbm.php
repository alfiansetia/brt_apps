<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Cbm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['unit_id'])) {
            $query->where('type', $filters['unit_id']);
        }
        if (isset($filters['component_id'])) {
            $query->where('type', $filters['component_id']);
        }
        if (isset($filters['pool_id'])) {
            $query->whereRelation('unit', 'pool_id',  $filters['pool_id']);
        }
        if (isset($filters['from']) && isset($filters['to'])) {
            $from = Carbon::parse($filters['from'])->startOfDay();
            $to = Carbon::parse($filters['to'])->endOfDay();
            $query->whereBetween('date', [$from, $to]);
        }
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
