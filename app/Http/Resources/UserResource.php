<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray($request)
    {
        $userType = 'NONE';
        if($this->regularUser) {
            $userType = 'REGULAR_USER';
        }
        if($this->admin) {
            $userType = 'ADMIN';
        }
        return [
          'id' => $this->id,
          'name' => $this->name,
          'email' => $this->email,
          'isApproved' => $this->is_approved,
          'emailVerified' => $this->email_verified_at,
          'userType' => $userType,
          'bloodType' => new BloodTypeResource($this->bloodType),
          'gender' => new GenderResource($this->gender),
          ...($this->regularUser ? [
            'educationalCertificates' => EducationalCertificateResource::collection($this->regularUser->educationalCertificates)
            ] : [
            'educationalCertificates' => []]
          ),

          'createdAt' => $this->created_at,
          'updatedAt' => $this->updated_at,
        ];
    }
}
