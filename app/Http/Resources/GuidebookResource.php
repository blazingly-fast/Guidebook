<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuidebookResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'uuid' => (string)$this->id,
      'attributes' => [
        'title' => $this->title,
        'description' => $this->description,
        'is_published' => $this->is_published,
      ],
      'relationships' => [
        'uuid' => (string)$this->user->id,
        'FirstName' => $this->user->first_name,
        'LastName' => $this->user->last_name,
        'Email' => $this->user->email
      ]
    ];
  }
}
