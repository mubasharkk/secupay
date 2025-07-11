<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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

        /* @phpstan-ignore variable.undefined */
        $data['vertrag'] = new ContractResource($this->contract); // @phpstan-ignore-line

        return $data;
    }
}
