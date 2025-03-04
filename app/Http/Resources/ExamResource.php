<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subject' => [
                "id"=>$this->subject->id,
                "name"=>$this->subject->name,
            ],
            'type' => $this->type,
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}