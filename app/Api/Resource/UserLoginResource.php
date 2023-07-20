<?php

namespace App\Api\Resource;


use Api\Resource\ShopUserResource;
use Hyperf\Resource\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'userinfo' => new ShopUserResource($this['userinfo']),
            'token' => $this['token'],
        ];
    }
}
