<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceItemResource extends JsonResource
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
            'label'         => $this->label,
            'image'         => $this->image,
            'service_id'    => $this->service_id,
            'service'       => new ServiceResource($this->whenLoaded('service')),
        ];
    }
}
