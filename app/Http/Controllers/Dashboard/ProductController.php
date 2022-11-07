<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category:id,name', 'store:id,name', 'tags:id,name')->paginate(7);
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::all();
        $categories = Category::all();
        return view('dashboard.products.create', compact('stores', 'categories'));
    }

    /**
     * Product a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255|unique:products,name',
            'store_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'compare_price' => 'nullable',
            'image' => 'nullable|image',
            'description' => 'nullable',
            'tags' => 'nullable'
        ]);
        $data = $request->except('image', 'tags');
        // slug
        $data['slug'] = Str::slug($request->name);
        // image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store(
                'products',
                'upload'
            );
            $data['image'] = $path;
        };
        //tags
        $tags = explode(',', $request->post('tags'));
        $all_tags = [];
        foreach ($tags as $tag_name) {
            $slug = Str::slug($tag_name);
            $tag = Tag::where('slug', $slug)->first();
            if(!$tag){
                $tag = Tag::create([
                    'name' => $tag_name,
                    'slug' => $slug,
                ]);
            }
            $all_tags[] = $tag->id;
        }
        $product = Product::create($data);
        $product->tags()->sync($all_tags);
        Alert::success(__('Congratulations'), __('Added seccessfly'));
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $stores = Store::all();
        $categories = Category::all();
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        
        return view('dashboard.products.edit', compact('product', 'stores', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required|min:2|max:255|unique:products,name,' . $product->id,
            'store_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'compare_price' => 'nullable',
            'image' => 'nullable|image',
            'description' => 'nullable',
        ]);
        $data = $request->except('image', 'tags');

        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('upload')->delete($product->image);
            }
            $path = $request->file('image')->store(
                'products',
                'upload'
            );
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }
         //tags
         $tags = explode(',', $request->input('tags'));

        $tags_ids = [];
        $all_tags = Tag::all();
        foreach ($tags as $tag) {
            $slug = Str::slug($tag);
            $mytag = $all_tags->where('slug', $slug)->first();
            if (!$mytag) {
                $mytag = Tag::create([
                    'name' => $tag,
                    'slug' => $slug,
                ]);
            }
            $tags_ids[] = $mytag->id;
        }
        $product->update($data);
        $product->tags()->sync($tags_ids);
        Alert::success(__('Congratulations'), __('Updated seccessfly'));
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($request->id);
        if ($product->image) {
            Storage::disk('upload')->delete($product->image);
        }
        $product->delete();
        Alert::success(__('Congratulations'), __('Deleted seccessfly'));
        return redirect()->route('admin.products.index');
    }
}
