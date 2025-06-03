<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'asc');
        $query = Category::query();

        if ($request->has('search') ) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('name', $sort)->paginate(10);
        $parentCategories = Category::whereIn('id', $categories->pluck('parent_id'))->pluck('name', 'id');
        return view('category.indexCategory')->with([
            'categories' => $categories,
            'parentCategories' => $parentCategories,
            'title' => ' List Categories',
            'heading' => ' List Categories',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $data = $request->only(['name', 'parent_id', 'description']);
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Category created successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)->pluck('name', 'id');
        return view('category.editCategory', [
            'category' => $category,
            'parentCategories' => $parentCategories,
            'title' => 'Edit Category',
            'heading' => 'Edit Category',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->name = $request->input('name');
        $category->slug = \Illuminate\Support\Str::slug($request->input('name'));
        $category->parent_id = $request->input('parent_id');
        $category->description = $request->input('description');
        $category->save();

        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Category updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('toastr', [
            'status' => 'success',
            'message' => 'Category deleted successfully.',
        ]);
    }
}
