<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\RateRecipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{

    public function index() {
        $users = User::all();
        return response($users, Response::HTTP_OK);
    }

    public function getUserName($user_id) {
        $user = User::find($user_id);
        return response($user->name, Response::HTTP_OK);
    }

    public function getFavorites($id)
    {
        //get all favorites of this user from DB pivot list
        $favorites = Favorite::where('users_id', $id)->get();
        $recipes = [];
        foreach ($favorites as $favorite) {
            $recipes[] = Recipe::find($favorite->recipes_id);
        } 
        return $recipes;
    }

    public function getLastsUsers() {
        $lastsUsers = User::where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count();
        return response($lastsUsers, Response::HTTP_OK);
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return response($user, Response::HTTP_OK);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
    }

    public function updateAvatar(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $data = $request->validate([
            'image' => 'required|image:jpeg,jpg,png'
        ]);

        $name = uniqid().'.'.$data['image']->extension();           	
        $data['image']->move(public_path('images/avatars'), $name);         
        $data['image'] = $name;     

        $user->avatar = $data['image'];
        $user->save();

        return response($user->avatar, Response::HTTP_OK);
    }

    public function getComments($id)
    {
        //get all comments of this user from DB pivot list ad then return with on-to-many relationship with recipes
        $rates = RateRecipe::where('user_id', $id)->with('recipe')->get();
        $recipes = [];
        foreach ($rates as $rate) {
            $recipes[] = Recipe::find($rate->recipe_id);
        }
        return compact(['rates', 'recipes']);
    }
}
