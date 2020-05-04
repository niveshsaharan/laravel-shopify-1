<?php

namespace Osiset\ShopifyApp\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Reprecents a single script tag from Shopify API.
 */
class ScriptTag extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request|null $request The request object.
     *
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
