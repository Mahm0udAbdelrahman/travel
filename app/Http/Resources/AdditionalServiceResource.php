<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name[app()->getLocale()] ?? $this->name['en'] ?? null,
            'description' => $this->description[app()->getLocale()] ?? $this->description['en'] ?? null,
            'image' => $this->image
        ];
    }
}
