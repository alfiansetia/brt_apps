<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
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
            'start_date'    => $this->start_date,
            'finish_date'   => $this->finish_date,
            'unit_detail'   => $this->unit_detail,
            'sn'            => $this->sn,
            'hm'            => $this->hm,
            'km'            => $this->km,
            'pool_id'       => $this->pool_id,
            'unit_id'       => $this->unit_id,
            'pool'          => new PoolResource($this->whenLoaded('pool')),
            'unit'          => new UnitResource($this->whenLoaded('unit')),
            'new_parts'     => PartItemResource::collection($this->whenLoaded('new_parts')),
            'old_parts'     => PartItemResource::collection($this->whenLoaded('old_parts')),
        ];
    }
}
