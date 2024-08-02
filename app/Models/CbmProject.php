<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbmProject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['pn'])) {
            $query->where('pn', 'like', '%' . $filters['pn'] . '%');
        }
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['pool_id'])) {
            $query->where('pool_id',  $filters['pool_id']);
        }
        if (isset($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }
    }

    public function actual(): int
    {
        $data = DmcrItem::whereRelation('dmcr', 'pool_id', $this->pool_id)
            ->where('part_number', $this->pn)
            ->sum('part_qty') ?? 0;
        return $data;
    }

    protected function casts(): array
    {
        return [
            'actual'    => 'integer',
            'target'    => 'integer',
            'id'        => 'integer',
            'pool_id'   => 'integer',
        ];
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
