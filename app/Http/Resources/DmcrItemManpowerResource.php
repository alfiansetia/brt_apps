<?php

namespace App\Http\Resources;

use App\Models\DmcrItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DmcrItemManpowerResource extends JsonResource
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
            'dmcr_item_id'  => $this->dmcr_item_id,
            'user'          => new UserResource($this->whenLoaded('user')),
            'dmcr_item'     => new DmcrItem($this->whenLoaded('dmcr_item')),
        ];
    }
}
