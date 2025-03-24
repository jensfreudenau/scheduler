<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'key' => $this->id,
            'label' => $this->description,
            'backgroundColor' => $this->text,
            'textColor' => '#000'
        ];
    }
}
