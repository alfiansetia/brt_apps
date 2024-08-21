<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'type'          => $this->type,
            'date'          => $this->date,
            'km'            => $this->km,
            'last_date'     => $this->last_date,
            'last_km'       => $this->last_km,
            'pool_id'       => $this->pool_id,
            'unit_id'       => $this->unit_id,
            'pool'          => new PoolResource($this->whenLoaded('pool')),
            'unit'          => new UnitResource($this->whenLoaded('unit')),
            'items'         => ServiceItemResource::collection($this->whenLoaded('items')),
            'date_parse'    => $this->date_parse(),
            'last_date_parse'    => $this->last_date_parse(),
        ];
    }
}
