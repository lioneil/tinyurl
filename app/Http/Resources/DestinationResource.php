<?php

namespace App\Http\Resources;

use App\Enums\DestinationStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'status' => DestinationStatus::getKeyFromValue($this->status),
            'status_code' => $this->status,
        ]);
    }
}
