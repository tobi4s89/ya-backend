<?php

namespace App\Transformers;

use App\Property;
use League\Fractal\TransformerAbstract;

class PropertyTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Property $property)
    {
        $data = [
            'id'    => $property->id,
            'name'  => $property->name
        ];

        if (isset($property['pivot'])) {
            $data['position'] = $property->pivot->position;
            $data['required'] = $property->pivot->required;
        }

        return $data;
    }
}
