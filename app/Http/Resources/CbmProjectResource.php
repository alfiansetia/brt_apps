<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CbmProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $target = $this->target;
        $actual = $this->actual();
        if ($target == 0 || $actual == 0) {
            $percent = 0;
        } else {
            $percent = floor($actual / $target * 100);
        }
        return [
            'id'        => $this->id,
            'DT_RowId'  => $this->id,
            'pn'        => $this->pn,
            'name'      => $this->name,
            'target'    => $target,
            'actual'    => $actual,
            'percent'   => $percent,
            'pool_id'   => $this->pool_id,
            'pool'      => new PoolResource($this->whenLoaded('pool')),
        ];
    }
}
