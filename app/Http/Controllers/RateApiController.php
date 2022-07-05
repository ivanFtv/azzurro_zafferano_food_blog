<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rate;
use App\Models\User;
use App\Models\Recipe;
use App\Models\RateRecipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RateApiController extends Controller
{
    public function index($id)
    {
        $rates = RateRecipe::where('recipe_id', $id)->get();
        return response($rates, Response::HTTP_OK);
    }

    public function store(Request $request) {
        $rate = new Rate;
        $rate->stars = $request->stars;
        $rate->name = $request->name;
        $rate->save();

        return response($rate, Response::HTTP_CREATED);
    }

    public function handleRates(Request $request)
    {
        $rate = new RateRecipe();
        $rate->user_id = $request->user_id;
        $rate->recipe_id = $request->recipe_id;
        $rate->rate_id = $request->stars;
        $rate->comment = $request->comment;
        $rate->save();

        return response($rate, Response::HTTP_OK);
    }

    public function getRatesByUser($user_id, $recipe_id) {
        $rate = RateRecipe::where('user_id', $user_id)->where('recipe_id', $recipe_id)->first();
        return response($rate, Response::HTTP_OK);
    }

    public function getRecipeAverageRates($id) {
        $rates = RateRecipe::where('recipe_id', $id)->get();
        if (count($rates) > 0) {
            $sum = 0;
            foreach ($rates as $rate) {
                $sum += $rate->rate_id;
            }
            $average = $sum / count($rates);
            return response($average, Response::HTTP_OK);
        } else {
            return response(null, Response::HTTP_OK);
        }
    }

    public function getLastsRates() {
        $lastRates = RateRecipe::where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count();
        return response($lastRates, Response::HTTP_OK);
    }

    public function getAllRates() {
        $rates = RateRecipe::all();
        return response($rates, Response::HTTP_OK);
    }

    public function destroy($id) {
        $rate = RateRecipe::findOrFail($id);
        $rate->delete();

        return response(null, Response::HTTP_OK);
    }

}
