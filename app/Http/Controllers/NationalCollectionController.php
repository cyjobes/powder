<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Socrata;

class NationalCollectionController extends Controller
{
    private $site_url;
    private $token;
    private $path;
    private $draw_days;
    private $continue;

    public function __construct($game = NULL)
    {
        switch($game) {
            case 'pb': // PowerBall
                $this->site_url = 'https://data.ny.gov';
                $this->token = 'KahHxdRJYPhZiELLLU1tuP22B';
                $this->path = '/resource/d6yy-54nr.json';
                $this->draw_days = array(3,6); // Wednesday, Saturday
                $this->continue = in_array(Carbon::now()->dayOfWeek, $this->draw_days);
                break;

            case 'mm': // MegaMillions
                $this->site_url = 'https://data.ny.gov';
                $this->token = 'KahHxdRJYPhZiELLLU1tuP22B';
                $this->path = '/resource/5xaw-6ayf.json';
                $this->draw_days = array(2,5); // Tuesday, Friday
                $this->continue = in_array(Carbon::now()->dayOfWeek, $this->draw_days);
                break;
        }
    }


    public function getDrawn()
    {
        if (!$this->continue) {
            return;
        }

        //$draw_date = Carbon::now()->sub('1', 'week')->format('Y-m-d').'T00:00:00.000';
        $draw_date = Carbon::now()->format('Y-m-d').'T00:00:00.000';
       // return $draw_date;

        $socrata = new Socrata($this->site_url, $this->token);
        $response = $socrata->get($this->path."?draw_date=$draw_date");
        if (!count($response)) {
            return 0;
        }

        return $response;
    }
}
