<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "Exam"=>$this->BaseQuestions->map(function($questions){
                return [
                    "question"=>$questions->question,
                    "base_exam_id"=>$questions->base_exam_id,
                ];
            })
        ];
    }
}
