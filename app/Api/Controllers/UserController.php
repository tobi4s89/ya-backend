<?php

namespace App\Api\Controllers;

use App\Property;
use App\User;
use App\UserProperty;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return fractal($users, new UserTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $properties = $request->input('properties');
        $user = User::create(['name' => $request->input('name')]);

        foreach($properties as $property) {
            $user->properties()->attach($property['id'], [
                'position' => $property['position'],
                'required' => $property['required']
            ]);
        }

        return response()->json([
            'status' => 'succes',
            'userId' => $user->id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
