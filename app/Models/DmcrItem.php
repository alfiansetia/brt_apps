<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DmcrItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'id'            => 'integer',
            'dmcr_id'       => 'integer',
            'component_id'  => 'integer',
            'part_qty'      => 'integer',
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['dmcr_id'])) {
            $query->where('dmcr_id', $filters['dmcr_id']);
        }
        if (isset($filters['pool_id'])) {
            $query->whereRelation('dmcr', 'pool_id',  $filters['pool_id']);
        }
        // if (isset($filters['from']) && isset($filters['to'])) {
        //     $from = Carbon::createFromFormat('d/m/Y', $filters['from'])->startOfDay();
        //     $to = Carbon::createFromFormat('d/m/Y', $filters['to'])->endOfDay();
        //     // $query->dmcr()->whereBetween('date', [$from, $to]);
        //     $query->whereHas('dmcr', function ($q) use ($from, $to) {
        //         $q->whereBetween('date', [$from, $to]);
        //     });
        // }
    }

    public function dmcr()
    {
        return $this->belongsTo(Dmcr::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function man_powers()
    {
        return $this->hasMany(DmcrItemManpower::class, 'dmcr_item_id', 'id');
    }
}
