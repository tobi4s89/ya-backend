<?php

namespace App\Api\Controllers;

use App\Algorithm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlgorithmController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request)
    {
        $firstUser = $request->header('first-user-id');
        $secondUser = $request->header('second-user-id');

        $comparison = Algorithm::compare($firstUser, $secondUser);

        $data = [
            'score' => $comparison->getScore(),
            'firstUser' => $comparison->getNameFirstUser(),
            'secondUser' => $comparison->getNameSecondUser(),
        ];

        return response()->json($data, 200);
    }
}
