<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DmcrItemManpower extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
        if (isset($filters['dmcr_item_id'])) {
            $query->where('dmcr_item_id',  $filters['dmcr_item_id']);
        }
    }

    public function dmcr_item()
    {
        return $this->belongsTo(DmcrItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
