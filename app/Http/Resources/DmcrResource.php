<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DmcrResource extends JsonResource
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
            'shift'         => $this->shift,
            'type'          => $this->type,
            'date'          => $this->date,
            'start'         => $this->start,
            'finish'        => $this->finish,
            'desc'          => $this->desc,
            'action'        => $this->action,
            'unit_id'       => $this->unit_id,
            'component_id'  => $this->component_id,
            'unit'          => new UnitResource($this->whenLoaded('unit')),
            'component'     => new ComponentResource($this->whenLoaded('component')),
            'man_powers'    => DmcrManpowerResource::collection($this->whenLoaded('man_powers')),
        ];
    }
}
