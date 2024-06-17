<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hmkm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
