@extends('layouts.dashboard.app')
@section('content')

<div class="row mx-3">
    <div class="col-lg-9">
        <form class="theme p-4" action="{{ route('admin.stores.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">@lang('Name')</label>
                        <x-form.input name="name" />
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Bio')</label>
                        <x-form.input name="bio" />                    
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">@lang('Image')</label>
                        <input type="file" class="form-control" name="image">
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