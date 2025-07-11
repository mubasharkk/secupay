<?php

namespace App\Http\Resources;

use App\Services\DataFlag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlagBitResource extends JsonResource
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
        $data['flagbit_name'] = DataFlag::getConstantNameById($this->flagbit); // @phpstan-ignore-line

        return $data;
    }
}
