<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hmkm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'id'        => 'integer',
            'unit_id'   => 'integer',
            'hm'        => 'integer',
            'km'        => 'integer',
            'hm_ac'     => 'integer',
            'breakpad1' => 'integer',
            'breakpad2' => 'integer',
            'breakpad3' => 'integer',
            'breakpad4' => 'integer',
            'breakpad5' => 'integer',
            'breakpad6' => 'integer',
            'pool_id'   => 'integer',
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['pool_id'])) {
            $query->where('hmkms.pool_id',  $filters['pool_id']);
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

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }
}
