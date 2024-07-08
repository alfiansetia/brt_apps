<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PpmData extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['date'])) {
            $query->where('date', 'like', '%' . $filters['date'] . '%');
        }
        if (isset($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }
        if (isset($filters['ppm_id'])) {
            $query->where('ppm_id', $filters['ppm_id']);
        }
        if (isset($filters['from']) && isset($filters['to'])) {
            $from = Carbon::createFromFormat('d/m/Y', $filters['from'])->startOfDay();
            $to = Carbon::createFromFormat('d/m/Y', $filters['to'])->endOfDay();
            $query->whereBetween('date', [$from, $to]);
        }
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }

    public function getFileAttribute($value)
    {
        if ($value && file_exists(public_path('assets/file/ppm/' . $value))) {
            return asset('assets/file/ppm/' . $value);
        } else {
            return null;
        }
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function ppm()
    {
        return $this->belongsTo(Ppm::class);
    }
}
