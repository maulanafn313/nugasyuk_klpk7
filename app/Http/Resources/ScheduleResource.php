<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'schedule_name' => $this->schedule_name,
            'category_id' => $this->category_id,
            'category' => $this->category,
            'priority' => $this->priority,
            'start_schedule' => $this->start_schedule,
            'due_schedule' => $this->due_schedule,
            'before_due_schedule' => $this->before_due_schedule,
            'upload_file' => $this->upload_file ? url('storage/' . $this->upload_file) : null,
            'url' => $this->url,
            'description' => $this->description,
            'status' => $this->status,
            'completed_at' => $this->completed_at,
            'collaborators' => $this->collaborators->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->pivot->role,
                ];
            }),
        ];
    }
}
