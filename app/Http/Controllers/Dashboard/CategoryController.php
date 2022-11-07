<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(7);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'description' => 'required|nullable',
        ]);
        $data = $request->except('slug');
        $data['slug'] = Str::slug($request->name);

        Category::create($data);
        Alert::success(__('Congratulations'), __('Added seccessfly'));
        return redirect()->route('admin.categories.index');

    }
    public function edit(Category $category)
    {

        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'description' => 'required|nullable',
        ]);

        $data = $request->except('slug');
        $data['slug'] = Str::slug($request->name);

        $category->update($data);
        Alert::success(__('Congratulations'), __('Updated seccessfly'));
        return redirect()->route('admin.categories.index');
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();
        Alert::success(__('Congratulations'), __('Deleted seccessfly'));
        return redirect()->route('admin.categories.index');
    }
}
