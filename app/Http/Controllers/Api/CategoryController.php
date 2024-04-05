<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json([
            "status" => true,
            "categories" => Category::with(["tasks"])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string"
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return response()->json([
            "status" => true,
            "message" => "Categoría creada exitosamente",
            "category" => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::where("id", $id)->first();
        if (!empty($category)) {
            $category->delete();
        } else {
            return response()->json([
                "status" => false,
                "message" => "No existe el registro",
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Categoría eliminada exitosamente",
            "category" => $category
        ]);
    }
}
