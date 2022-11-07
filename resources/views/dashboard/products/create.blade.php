@extends('layouts.dashboard.app')
@section('title')
@lang('Products')
@endsection
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row mx-3">
    <div class="col-lg-9">
        <form class="theme p-4" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Name')</label>
                        <x-form.input name="name" />
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Store')</label>
                        <select name="store_id" class="form-control">
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>                                 
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Category')</label>
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>               
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Price')</label>
                        <x-form.input name="price" />                    
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Compare Price')</label>
                        <x-form.input name="compare_price" />                    
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Quantity')</label>
                        <x-form.input name="quantity" />                    
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Description')</label>
                        <x-form.input name="description" />                    
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Image')</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Tags')</label>
                        <x-form.input name="tags" placeholder="cotton, discount, bangladish"/>
                    </div>
                </div>

            </div>


            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-lg w-100 m-2 MyBtn">@lang('Add')</button>

            </div>
        </form>
    </div>
</div>

@endsection