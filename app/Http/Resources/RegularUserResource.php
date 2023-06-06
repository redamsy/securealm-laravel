<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegularUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'isApproved' => $this->user->is_approved,
            'emailVerifiedAt' => $this->user->email_verified_at,
            'bloodType' => new BloodTypeResource($this->user->bloodType),
            'gender' => new GenderResource($this->user->gender),
            'roleAssignmentDate'=> $this->created_at,
            'createdAt' => $this->user->created_at,
            'updatedAt' => $this->user->updated_at,
          ];
    }
}
