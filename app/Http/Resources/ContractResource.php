<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['zeitraum_von'] = $data['von'];
        $data['zeitraum_bis'] = $data['bis'];

        unset($data['von'], $data['bis']);

        /* @phpstan-ignore variable.undefined */
        $data['nutzer'] = $this->user; // @phpstan-ignore-line

        return $data;
    }
}
