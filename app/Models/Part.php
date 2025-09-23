<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Part extends Model
{
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['pool_id'])) {
            $query->where('parts.pool_id',  $filters['pool_id']);
        }
        if (isset($filters['unit_id'])) {
            $query->where('parts.unit_id',  $filters['unit_id']);
        }
    }

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }

    protected function startDateIndo(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::parse($attributes['start_date'])
                ->translatedFormat('d F Y')
        );
    }
    
    protected function finishDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }
     protected function finishDateIndo(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::parse($attributes['finish_date'])
                ->translatedFormat('d F Y')
        );
    }

    public function new_parts(){
        return $this->hasMany(PartItem::class)->where('type', 'new');
    }


    public function old_parts(){
        return $this->hasMany(PartItem::class)->where('type', 'old');
    }

    public function all_parts(){
        return $this->hasMany(PartItem::class);
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
