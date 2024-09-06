<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.category.add_category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;

        if ($request->hasFile('image')) {


            // Store new photo and update user record
            $image = $request->file('image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/category'), $image_name);

            // Only store the file name in the database
            $category->image = $image_name;
        }

        $category->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Category created successfully.'
        ];
        return redirect()->route('admin.all_categories')->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.backend.category.edit_category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => ['required', Rule::unique('categories')->ignore($category->id)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update category name
        $category->category_name = $request->category_name;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image && file_exists(public_path('upload/category/' . $category->image))) {
                unlink(public_path('upload/category/' . $category->image));
            }

            // Store new image
            $image = $request->file('image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/category'), $image_name);

            // Only store the new file name in the database
            $category->image = $image_name;
        }

        // Save updated category
        $category->save();

        // Redirect with a success notification
        $notification = [
            'alert-type' => 'success',
            'message' => 'Category updated successfully.'
        ];
        return redirect()->route('admin.all_categories')->with($notification);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if the category has an image and if it exists in the directory
        if ($category->image && file_exists(public_path('upload/category/' . $category->image))) {
            // Delete the image from the directory
            unlink(public_path('upload/category/' . $category->image));
        }
        $category->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Category deleted successfully.'
        ];
        return redirect()->route('admin.all_categories')
            ->with($notification);
    }
}
