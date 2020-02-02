<?php

namespace App\Http\Controllers;

setlocale(LC_MONETARY, 'en_NG');

use App\Traits\Pagnitable;
use App\Traits\Sortable;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class MovieController extends Controller
{
    use Sortable;
    use Pagnitable;

    public $movieClient;
    static $sortKeys = ["asc" => true, "desc" => true];


    /**
     * Fetches all movies from api
     *
     */
    public function movies()
    {
        $this->movieClient = new Client(['base_uri' => 'https://the-one-api.herokuapp.com']);
        $result = $this->movieClient->get('v1/movie', [
            'headers' =>
            [
                'Authorization' => "Bearer " . config('app.lors_key')
            ]
        ]);
        $allMovies = json_decode($result->getBody()->getContents());
        return $allMovies;
    }

    /**
     * Return movies based on user criteria
     * specified in the param body
     *
     * @param Illuminate\Http\Request $request
     */
    public function all(Request $request)
    {
        $budget = $request->budget;
        $runtime = $request->runtime;
        $boxRevenue = $request->boxOfficeRevenue;
        $moviesCollection = collect($this->movies()->docs);
        $sorted = $this->sortBy($this->buildSortingCriteria($budget, $runtime, $boxRevenue), $moviesCollection);
        $transformedData = $this->transformCurrencies($sorted);
        $result = $request->pageSize ?
            $this->paginate($transformedData, $transformedData->count(), $request->pageSize) :
            $transformedData;
        return response()->json($result, 200);
    }

    /**
     * \Transform currencies in
     * data to naira
     *
     * @param  \Illuminate\Support\Collection $data
     *
     * @return \Illuminate\Support\Collection
     */
    public function transformCurrencies($data)
    {
        $data->map(function ($movie) {
            $budgetNaira = ((int) $movie->budgetInMillions)  * 350 * 1000000;
            $boxOfficeRevenueNaira = ((int) $movie->boxOfficeRevenueInMillions)  * 350 * 1000000;
            $movie->budgetInNaira = number_format($budgetNaira);
            $movie->boxOfficeRevenueNaira = number_format($boxOfficeRevenueNaira);
            unset($movie->budgetInMillions);
            unset($movie->boxOfficeRevenueInMillions);
        });

        return $data;
    }

    /**
     * Checks if a predefined filtering
     * criteria is present and uses it to
     * build an array of criteria
     *
     * @param  string budget
     * @param string runtime
     * @param string boxRevenue
     *
     * @return array
     */
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
