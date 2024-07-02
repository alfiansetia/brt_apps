<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Speed extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['pool_id'])) {
            $query->whereRelation('items.unit', 'pool_id',  $filters['pool_id']);
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

    public function items()
    {
        return $this->hasMany(SpeedItem::class);
    }
}
