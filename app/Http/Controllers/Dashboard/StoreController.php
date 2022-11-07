<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::paginate(7);
        return view('dashboard.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'bio' => 'nullable',
            'image' => 'nullable|image'
        ]);
        $data = $request->except('image');
        
        $data['slug'] = Str::slug($request->name);
        if($request->hasFile('image')){
            $path = $request->file('image')->store(
                'stores','upload'
            );
            $data['image'] = $path;
        };
        Store::create($data);
        Alert::success(__('Congratulations'), __('Added seccessfly'));
        return redirect()->route('admin.stores.index');

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
    public function edit(Store $store)
    {

        return view('dashboard.stores.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'bio' => 'nullable',
            'image' => 'nullable|image'
        ]);
        $data = $request->except('image');
        
        $data['slug'] = Str::slug($request->name);

        if($request->hasFile('image')){
            if($store->image){
                Storage::disk('upload')->delete($store->image);
            }
            $path = $request->file('image')->store(
                'stores','upload'
            );
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }
        $store->update($data);
        Alert::success(__('Congratulations'), __('Updated seccessfly'));
        return redirect()->route('admin.stores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $store = Store::findOrFail($request->id);
        if($store->image)
        {
            Storage::disk('upload')->delete($store->image);
        }
        $store->delete();
        Alert::success(__('Congratulations'), __('Deleted seccessfly'));
        return redirect()->route('admin.stores.index');
    }
}
