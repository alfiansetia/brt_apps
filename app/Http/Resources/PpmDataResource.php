<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PpmDataResource extends JsonResource
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
            'unit_id'       => $this->unit_id,
            'ppm_id'        => $this->ppm_id,
            'file'          => $this->file,
            'ppm'           => new PpmResource($this->whenLoaded('ppm')),
            'unit'          => new UnitResource($this->whenLoaded('unit')),
        ];
    }
}
