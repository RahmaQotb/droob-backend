<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'text' => $this->text,
            'type' => $this->type,
            'image' => $this->image,
            'exam_id' => $this->exam_id,
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),
        ];

    }
}