<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class FavoriteApiController extends Controller
{
    public function index()
    {
       //
    }

    public function handleFavorites(Request $request) {
        //check if exists a record with the same user_id and recipe_id then delete it
        $favorite = Favorite::where('users_id', $request->user_id)->where('recipes_id', $request->recipe_id)->first();
        if($favorite) {
            $favorite->delete();
            return response('Favorite removed', Response::HTTP_OK);
        } else {
            $favorite = new Favorite();
            $favorite->users_id = $request->user_id;
            $favorite->recipes_id = $request->recipe_id;
            $favorite->save();
            return response('Favorite added', Response::HTTP_OK);
        }

        return response($favorite, Response::HTTP_CREATED);
    }

    public function destroy($id) {
        // return $id;
        $favorite = Favorite::where('recipes_id', $id)->first();
        $favorite->delete();

        return response(null, Response::HTTP_OK);
    }

    public function getByUser($id) {
        $favorites = Favorite::where('users_id', $id)->get();
        $recipes = [];
        foreach ($favorites as $favorite) {
            $recipes[] = Recipe::find($favorite->recipes_id);
        }
       
        return response($recipes, Response::HTTP_OK);
    }
}
