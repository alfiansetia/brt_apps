<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'id'            => 'integer',
            'service_id'    => 'integer',
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['label'])) {
            $query->where('label', 'like', '%' . $filters['label'] . '%');
        }
        if (isset($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function imagepath()
    {
        $val = $this->getRawOriginal('image');
        if ($val && file_exists(public_path('assets/img/service/' . $val))) {
            return public_path('assets/img/service/' . $val);
        } else {
            return public_path('assets/img/noimage.jpg');
        }
    }

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('assets/img/service/' . $value))) {
            return asset('assets/img/service/' . $value);
        } else {
            return asset('assets/img/noimage.jpg');
        }
    }
}
