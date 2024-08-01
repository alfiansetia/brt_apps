<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Dmcr extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
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

    protected function start(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y H:i:s'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s'),
        );
    }

    protected function finish(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y H:i:s'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s'),
        );
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // public function component()
    // {
    //     return $this->belongsTo(Component::class);
    // }

    // public function man_powers()
    // {
    //     return $this->hasMany(DmcrManpower::class);
    // }

    public function items()
    {
        return $this->hasMany(DmcrItem::class);
    }
}
