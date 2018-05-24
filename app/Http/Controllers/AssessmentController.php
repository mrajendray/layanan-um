<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assessment;

class AssessmentController extends Controller
{
    function index() {
        return view('assessment');
    }

    function submit(Request $request) {
        // enumeration
        $rate['excellent']=0;$rate[0]='excellent';
        $rate['good']=1;$rate[1]='good';
        $rate['bad']=2;$rate[2]='bad';
        $rate['very_bad']=3;$rate[3]='very_bad';

        $assessment = $request->rating;
        if ($assessment < 0 || $assessment >= 4)
            dd("ERROR");

        // preapre save data
        $newAssessment = array(
            "id_fakultas" => $request->session()->get("fakultas_id"),
            "rating" => $rate[$assessment],
            "created_at" => date("Y-m-d H:i:s")
        );
        Assessment::insert($newAssessment);

        return 'thankyou';
    }
}
