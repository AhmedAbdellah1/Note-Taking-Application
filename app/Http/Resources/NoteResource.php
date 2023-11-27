<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{

    // Transform the resource into an array.

    public function toArray(Request $request): array
    {
        return [
            'note_number' => $this->id,
            'note_title' => $this->title,
            'note_content' => $this->content,
            'user_id' => $this->user_id,
        ];
    }
}
