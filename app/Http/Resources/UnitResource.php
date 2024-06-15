<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'id'                => $this->id,
            'DT_RowId'          => $this->id,
            'code'              => $this->code,
            'type'              => $this->type,
            'desc'              => $this->desc,
            'pool_id'           => $this->pool_id,
            'pool'              => new PoolResource($this->whenLoaded('pool')),
        ];
    }
}
