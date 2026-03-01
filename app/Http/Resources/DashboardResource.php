<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
            ],
            'gamification' => $this->resource['gamification'] ?? null,
            'financial_summary' => $this->resource['financial_summary'] ?? null,
            'recent_transactions' => TransactionResource::collection(
                $this->resource['recent_transactions'] ?? collect()
            ),
        ];
    }
}