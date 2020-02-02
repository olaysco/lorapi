<?php

namespace App\Http\Controllers;

setlocale(LC_MONETARY, 'en_NG');

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class MovieController extends Controller
{
    public $movieClient;
    static $sortKeys = ["asc" => true, "desc" => true];

    public function movies()
    {
        $this->movieClient = new Client(['base_uri' => 'https://the-one-api.herokuapp.com']);
        $result = $this->movieClient->get('v1/movie', [
            'headers' =>
            [
                'Authorization' => "Bearer yERyK42VbOR0RmdobjE2"
            ]
        ]);
        $allMovies = json_decode($result->getBody()->getContents());
        return $allMovies;
    }

    public function all(Request $request)
    {
        $budget = $request->budget;
        $runtime = $request->runtime;
        $boxRevenue = $request->boxOfficeRevenue;
        return $this->sortBy($this->buildSortingCriteria($budget, $runtime, $boxRevenue));
    }

    public function sortBy(array $sortingCriteria)
    {
        $moviesCollection = collect($this->movies()->docs);
        foreach ($sortingCriteria as $criteria => $order) {
            if ($order === 'asc') {
                $moviesCollection = $moviesCollection->sortBy($criteria);
            } else {
                $moviesCollection = $moviesCollection->sortByDesc($criteria);
            }
        }
        $moviesCollection->map(function ($movie) {
            $budgetNaira = ((int) $movie->budgetInMillions)  * 350 * 1000000;
            $boxOfficeRevenueNaira = ((int) $movie->boxOfficeRevenueInMillions)  * 350 * 1000000;
            $movie->budgetInNaira = number_format($budgetNaira);
            $movie->boxOfficeRevenueNaira = number_format($boxOfficeRevenueNaira);
            unset($movie->budgetInMillions);
            unset($movie->boxOfficeRevenueInMillions);
        });
        return response()->json($moviesCollection, 200);
    }

    public function buildSortingCriteria($budget = "", $runtime = "", $boxRevenue = "")
    {
        $sortingCriteria = [];

        if (!empty($budget) && Arr::has(self::$sortKeys, $budget)) {
            $sortingCriteria["budgetInMillions"] = $budget;
        }
        if (!empty($runtime) && Arr::has(self::$sortKeys, $runtime)) {
            $sortingCriteria["runtimeInMinutes"] = $runtime;
        }
        if (!empty($boxRevenue) && Arr::has(self::$sortKeys, $boxRevenue)) {
            $sortingCriteria["boxOfficeRevenueInMillions"] = $boxRevenue;
        }

        return $sortingCriteria;
    }
}
