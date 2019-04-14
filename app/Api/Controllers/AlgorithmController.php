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
        $firstUser = $request->query('first_user_id');
        $secondUser = $request->query('second_user_id');

        $comparison = Algorithm::compare($firstUser, $secondUser);

        $data = [
            'score' => $comparison->getScore(),
            'firstUser' => $comparison->getNameFirstUser(),
            'secondUser' => $comparison->getNameSecondUser(),
            'matchingItems' => $comparison->getMatchingItems()
        ];

        return response()->json($data, 200);
    }
}
