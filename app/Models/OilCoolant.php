<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OilCoolant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        if (isset($filters['pool_id'])) {
            $query->whereRelation('unit', 'pool_id',  $filters['pool_id']);
        }
        if (isset($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }
        if (isset($filters['from']) && isset($filters['to'])) {
            $from = Carbon::parse($filters['from'])->startOfDay();
            $to = Carbon::parse($filters['to'])->endOfDay();
            $query->whereBetween('date', [$from, $to]);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
