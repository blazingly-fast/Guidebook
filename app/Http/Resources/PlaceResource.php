<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
			],
			'relationships' => [
				'guidebook_uuid' => (string)$this->guidebook->id
			]
		];
	}
}
