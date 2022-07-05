<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Recipe;
use Psr\Log\NullLogger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreRecipeRequest;

class RecipeApiController extends Controller
{

    public function index()
    {
        $recipes = Recipe::all();
        return response()->json($recipes);
    }

    public function store(Request $request) {

        $validateData = $request->validate([
            'users_id' => 'required',
            'name' => 'required',
            'image' => 'required|image:png,jpg,jpeg',
            'ingredients' => 'required',
            'text' => 'required',
            'keywords' => 'required',
            'category' => 'required'
        ]);
        
        if($validateData['image']) {         	
            $name = uniqid().'.'.$validateData['image']->extension();           	
            $validateData['image']->move(public_path('images/recipes_images'), $name);         
            $validateData['image'] = $name;     	
            } else {
            $validateData['image'] = 'default.png';
            };

            $recipe = new Recipe();
            $recipe->users_id = $validateData['users_id'];
            $recipe->name = $validateData['name'];
            $recipe->text = $validateData['text'];
            $recipe->ingredients = $validateData['ingredients'];
            $recipe->img = $validateData['image'];
            $recipe->keywords = $validateData['keywords'];
            $recipe->category = $validateData['category'];
            $recipe->save();

        return response('ok', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id) {

        // return $request;

        $validateData = $request->validate([
            'name' => 'required',
            'ingredients' => 'required',
            'text' => 'required',
            'keywords' => 'required',
            'category' => 'required'
        ]);

        
        if  (is_file($request->image)) {         	
            $name = uniqid().'.'.$request->image->extension();           	
            $request->image->move(public_path('images/recipes_images'), $name);         
            $request->image = $name;     	
        };

            $recipe = Recipe::findOrFail($id);
            $recipe->name = $validateData['name'];
            $recipe->text = $validateData['text'];
            $recipe->ingredients = $validateData['ingredients'];
            $recipe->img = $request->image;
            $recipe->keywords = $validateData['keywords'];
            $recipe->category = $validateData['category'];
            $recipe->save();

        return response('ok', Response::HTTP_CREATED);
    }

    public function getByCat($cat)
    {
        $recipes = Recipe::where('category', $cat)->get();
        return response()->json($recipes);
    }

    public function getSuggested($key)
    {
        $recipes = Recipe::where('keywords', 'LIKE', '%'.$key.'%')
        ->inRandomOrder()
        ->limit(3)
        ->get();
        return response()->json($recipes);
    }


    public function getAllRecipes() {
        $allRecipes = Recipe::all()->count();
        return response($allRecipes, Response::HTTP_OK);
    }

    public function destroy($id) {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response(null, Response::HTTP_OK);
    }

}
