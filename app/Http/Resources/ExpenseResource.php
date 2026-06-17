<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'amount'      => $this->amount,
            'date'        => $this->date->toDateString(),
            'description' => $this->description,
            'category'    => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
            ],
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
