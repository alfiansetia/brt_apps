<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'id'        => 'integer',
            'unit_id'   => 'integer',
            'pool_id'   => 'integer',
            'km'        => 'integer',
            'last_km'   => 'integer',
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        if (isset($filters['pool_id'])) {
            $query->where('services.pool_id', $filters['pool_id']);
        }
        if (isset($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }

    protected function lastDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }

    public function date_parse()
    {
        $date = Carbon::parse($this->getRawOriginal('date'));
        $date->locale('id');
        return $date->translatedFormat('d F Y');
    }

    public function last_date_parse()
    {
        $date = Carbon::parse($this->getRawOriginal('last_date'));
        $date->locale('id');
        return $date->translatedFormat('d F Y');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }
}
