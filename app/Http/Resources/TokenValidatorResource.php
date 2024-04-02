<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenValidatorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $message = $this->resource->isValid ? 'Valid token' : $this->resource->message;

        $response = [
            'isValid' => $this->resource->isValid,
        ];
        $response['message'] = $message;

        return $response;
    }
}
