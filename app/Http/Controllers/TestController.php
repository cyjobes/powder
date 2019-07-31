<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Socrata;
use App\Http\Controllers\NationalCollectionController;

class TestController extends Controller
{
    public function test()
    {
        $socrata = new Socrata("https://data.ny.gov", "KahHxdRJYPhZiELLLU1tuP22B");
         $response = $socrata->get("/resource/5xaw-6ayf.json?draw_date=2019-07-23T00:00:00.000");
        //$response = $socrata->get('/resource/5xaw-6ayf?$limit=60');
        dd($response);
    }

    public function getDrawnMegaMillions() {
        $national = new NationalCollectionController('mm');
        return $national->getDrawn();
    }


    public function getDrawnPowerBall() {
        $national = new NationalCollectionController('pb');
        return $national->getDrawn();
    }
}
