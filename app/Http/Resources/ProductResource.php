<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $description
 * @property mixed $type
 * @property mixed $category
 * @property mixed $price
 * @property mixed $quantity
 * @property mixed $manufacturer
 * @property mixed $distributor
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource ? [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'category' => $this->category,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'manufacturer' => $this->manufacturer,
            'distributor' => $this->distributor,
        ] : [];
    }
}
