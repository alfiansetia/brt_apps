<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogbookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $prepart = explode(':', $this->pre);
        $startpart = explode(':', $this->start);
        $finishpart = explode(':', $this->finish);
        $pre = $prepart[0] . ':' . $prepart[1];
        $start = $startpart[0] . ':' . $startpart[1];
        $finish = $finishpart[0] . ':' . $finishpart[1];
        return [
            'id'            => $this->id,
            'DT_RowId'      => $this->id,
            'date'          => $this->date,
            'location'      => $this->location,
            'pre'           => $this->pre,
            'start'         => $this->start,
            'finish'        => $this->finish,
            'problem'       => $this->problem,
            'action'        => $this->action,
            'status'        => $this->status,
            'desc'          => $this->desc,
            'unit_id'       => $this->unit_id,
            'component_id'  => $this->component_id,
            'unit'          => new UnitResource($this->whenLoaded('unit')),
            'component'     => new ComponentResource($this->whenLoaded('component')),
            'man_powers'    => LogbookManpowerResource::collection($this->whenLoaded('man_powers')),
            'pre_parse'     => $pre,
            'start_parse'   => $start,
            'finish_parse'  => $finish,
        ];
    }
}
