<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
            $query->where('pool_id',  $filters['pool_id']);
        }
        if (isset($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }
        if (isset($filters['from']) && isset($filters['to'])) {
            $from = Carbon::createFromFormat('d/m/Y', $filters['from'])->startOfDay();
            $to = Carbon::createFromFormat('d/m/Y', $filters['to'])->endOfDay();
            $query->whereBetween('date', [$from, $to]);
        }
        if (isset($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
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
