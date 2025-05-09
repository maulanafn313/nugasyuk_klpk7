<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryScheduleController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $categories = Category::all();
        return view('admin.category.index', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'schedule_category' => 'required|string|max:100|unique:categories',
            ]);

            Category::create([
                'schedule_category' => $validated['schedule_category']
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'redirect' => route('admin.category.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'schedule_category' => 'required|string|max:100|unique:categories,schedule_category,' . $category->id,
            ]);

            $category->update([
                'schedule_category' => $validated['schedule_category']
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'redirect' => route('admin.category.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully',
                'redirect' => route('admin.category.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete category'
            ], 422);
        }
    }
}