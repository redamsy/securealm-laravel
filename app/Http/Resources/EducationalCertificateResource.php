<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationalCertificateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
        //   $this->mergeWhen($this->needsFullData($request), [
        //     'regularUsers' => RegularUserResource::collection($this->regularUsers),
        //   ]),
          'createdAt' => $this->created_at,
          'updatedAt' => $this->updated_at,
        ];
    }
    protected function needsFullData($request)
    {
        $adminExists = Admin::where('user_id', Auth::user()->id )->exists();
        if($adminExists && $request->includeUsers){
            return true;
        }
        return false;
    }
}
