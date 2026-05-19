<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->save();

        return back()->with('success', 'New category created successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category is being used by any tickets before deleting
        if ($category->tickets()->count() > 0) {
            return back()->with('error', 'Cannot delete category that is linked to existing tickets.');
        }

        $category->delete();
        return back()->with('success', 'Category removed.');
    }
}
