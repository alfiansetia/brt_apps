<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OilCoolantResource extends JsonResource
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
            'amount'        => $this->amount,
            'type'          => $this->type,
            'desc'          => $this->desc,
            'user_id'       => $this->user_id,
            'unit_id'       => $this->unit_id,
            'pool_id'       => $this->pool_id,
            'product_id'    => $this->product_id,
            'pool'          => new PoolResource($this->whenLoaded('pool')),
            'user'          => new UserResource($this->whenLoaded('user')),
            'unit'          => new UnitResource($this->whenLoaded('unit')),
            'product'       => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
