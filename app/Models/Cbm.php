<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Cbm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'id'            => 'integer',
            'unit_id'       => 'integer',
            'component_id'  => 'integer',
            'pool_id'       => 'integer',
            'km'            => 'integer',
        ];
    }

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
            $query->where('cbms.pool_id',  $filters['pool_id']);
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

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
