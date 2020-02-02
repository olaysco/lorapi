<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class MovieController extends Controller
{
    public $movieClient;
    public function all()
    {
        $this->movieClient = new Client(['base_uri' => 'https://the-one-api.herokuapp.com']);
        $result = $this->movieClient->get('v1/movie', [
            'headers' =>
            [
                'Authorization' => "Bearer yERyK42VbOR0RmdobjE2"
            ]
        ]);
        $allMovies = json_decode($result->getBody()->getContents());
        return response()->json($allMovies, 200);
    }
}
