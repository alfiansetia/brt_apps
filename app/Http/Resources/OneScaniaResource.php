<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneScaniaResource extends JsonResource
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
            'name'              => $this->name,
            'unit'              => $this->unit,
            'component'         => $this->component,
            'number'            => $this->number,
            'satuan_map'        => $this->satuan_map,
            'price_map'         => $this->price_map,
            'price_map_parse'   => hrg($this->price_map),
            'satuan_vendor'     => $this->satuan_vendor,
            'price_vendor_parse' => hrg($this->price_vendor),
            'vendor'            => $this->vendor,
            'brand'             => $this->brand,
            'remark'            => $this->remark,
            'file'              => $this->file,
        ];
    }
}
