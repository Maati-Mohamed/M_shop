@extends('layouts.dashboard.app')
@section('title')
@lang('Categories')
@endsection
@section('content')

<div class="theme p-3">
    <table class="table align-middle">

        <a href="{{ route('admin.categories.create') }}" class="btn MyBtn mb-2"><span><i class="bi bi-plus"></i> @lang('Add')</span></a>

        <thead class="">
            <tr>
                <th>Name</th>
                <th>@lang('Descrption')</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>
                    {{ $category->name }}
                </td>
                <td>
                    {{ $category->description }}
                </td>
                <td class="d-flex gap-2">

                    <a href="{{ route('admin.categories.edit',$category->id) }}" class="btn btn-outline-primary"><span><i class="bi bi-pencil-square"></i></span></a>

                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-userId="{{ $category->id }}"><span><i class="bi bi-trash3"></i></span></button>

                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>




<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="text-center p-5">@lang('Are you sure to delete') ؟</h2>
                <form action="{{ url('admin/categories/destroy') }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="mb-3">
                        <input type="hidden" class="form-control" value="" name="id" id="id">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                <button type="submit" class="btn btn-danger">@lang('Delete')</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{ $categories->withQueryString()->links() }}
@endsection