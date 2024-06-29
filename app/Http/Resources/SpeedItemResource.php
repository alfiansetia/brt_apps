<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeedItemResource extends JsonResource
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
            'value'         => $this->value,
            'speed_id'      => $this->speed_id,
            'unit_id'       => $this->unit_id,
            'unit'          => new UnitResource($this->whenLoaded('unit')),
        ];
    }
}
