<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogbookManpowerResource extends JsonResource
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
            'user_id'       => $this->user_id,
            'logbook_id'    => $this->logbook_id,
            'user'          => new UserResource($this->whenLoaded('user')),
            'logbook'       => new LogbookResource($this->whenLoaded('logbook')),
        ];
    }
}
