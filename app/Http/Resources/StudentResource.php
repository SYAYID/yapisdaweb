<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
    return [
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
        'registration_date' => $this->created_at->format('Y-m-d'),
        'status' => $this->status, // e.g., 'pending', 'verified'
        // ❌ JANGAN kirim: NIK, password, alamat lengkap, foto KTP, dll.
    ];
}
}
