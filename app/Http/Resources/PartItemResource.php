<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartItemResource extends JsonResource
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
            'image'         => $this->image,
            'part_id'       => $this->part_id,
            'part'          => new PartResource($this->whenLoaded('part')),
        ];
    }
}
