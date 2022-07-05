<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('rates', 'favorites')->get();
        return response($recipes, Response::HTTP_OK);
    }

    public function store(Request $request)
    {

        $request->validate([
            'users_id' => 'required',
            'name' => 'required',
            'text' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keywords' => 'required',
            'category' => 'required'
        ]);
        $recipe = new Recipe;
        $recipe->users_id = $request->users_id;
        $recipe->name = $request->name;
        $recipe->text = $request->text;
        if($request->image) {         	
            $name = uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('images/recipes_images'), $name);
            $recipe->image = $name;     	
            }    	
        $recipe->keywords = $request->keywords;
        $recipe->category = $request->category;
        $recipe->save();

        return response($recipe, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->user_id = $request->user_id;
        $recipe->name = $request->name;
        $recipe->text = $request->text;
        if($request->image) {         	
            $name = uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('images/recipes_images'), $name);
            $recipe->image = $name;     	
            }
            
        $recipe->keywords = $request->keywords;
        $recipe->category = $request->category;
        $recipe->save();

        return response($recipe, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response(null, Response::HTTP_OK);
    }

    public function show($id)
    {
        $recipe = Recipe::findOrFail($id);
        return view('recipes.show')->with('recipe', $recipe);
    }

    public function getByFilter($key)
    {
        return view('recipes.lists')->with('key', $key);
    }

    public function getBySearch($search)
    {
        $recipes = Recipe::where('name', 'LIKE', '%'.$search.'%')->get();
        return view('recipes.search')->with('recipes', $recipes)->with('searched', $search);
    }


}
