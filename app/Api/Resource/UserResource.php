<?php

namespace App\Api\Resource;

use Hyperf\Resource\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'phone' => $this['phone'],
            'email' => $this['email'],
        ];
    }
}
