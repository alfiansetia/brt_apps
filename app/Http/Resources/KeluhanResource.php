<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeluhanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'            => $this->id,
            'DT_RowId'      => $this->id,
            'date'          => $this->date,
            'name'          => $this->name,
            'km'            => $this->km,
            'keluhan'       => $this->keluhan,
            'r1'            => $this->r1,
            'r2'            => $this->r2,
            'r3_4'          => $this->r3_4,
            'r5_6'          => $this->r5_6,
            'r7_8'          => $this->r7_8,
            'r9_10'         => $this->r7_8,
            'responsible'   => $this->responsible,
            'status'        => $this->status,
            'activity'      => $this->activity,
            'unit_id'       => $this->unit_id,
            'unit'          => new UnitResource($this->whenLoaded('unit')),
        ];
    }
}
