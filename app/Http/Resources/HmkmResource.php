<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HmkmResource extends JsonResource
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
            'id'        => $this->id,
            'DT_RowId'  => $this->id,
            'date'      => $this->date,
            'hm'        => $this->hm,
            'km'        => $this->km,
            'hm_ac'     => $this->hm_ac,
            'desc'      => $this->desc,
            'unit_id'   => $this->unit_id,
            'unit'      => new UnitResource($this->whenLoaded('unit')),
        ];
    }
}
