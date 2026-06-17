<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'amount'     => $this->amount,
            'period'     => $this->period,
            'category'   => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
                'type' => $this->category->type,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
