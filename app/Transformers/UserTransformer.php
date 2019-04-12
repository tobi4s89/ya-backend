<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'            =>  $user->id,
            'name'          =>  $user->name,
            'properties'    =>  fractal($user->properties, new PropertyTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
        ];
    }
}
