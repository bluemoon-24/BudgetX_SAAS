<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavingsGoalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'target_amount'  => $this->target_amount,
            'current_amount' => $this->current_amount,
            'target_date'    => $this->target_date ? $this->target_date->toDateString() : null,
            'created_at'     => $this->created_at->toDateTimeString(),
        ];
    }
}
