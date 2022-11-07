@extends('layouts.dashboard.app')
@section('title')
@lang('Stores')
@endsection
@section('content')

<table class="table align-middle theme">
   
    <a href="{{ route('admin.stores.create') }}" class="btn MyBtn mb-2"><span><i class="bi bi-plus"></i> @lang('Add')</span></a>
    
    <thead class="">
        <tr>
            <th>Name</th>
            <th>@lang('image')</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stores as $store)
        <tr>
            <td>
              {{ $store->name }}
            </td>
            <td>
            <img src="{{ $store->image_path }}" class="rounded-circle" alt="" style="width: 45px; height: 45px" />

            </td>
            <td class="d-flex gap-2">
                
                <a href="{{ route('admin.stores.edit',$store->id) }}" class="btn btn-outline-primary"><span><i class="bi bi-pencil-square"></i></span></a>
                
                <button class="btn btn-outline-danger"
                data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-userId="{{ $store->id }}"
                ><span><i class="bi bi-trash3"></i></span></button>
               
            </td>
        </tr>
        @endforeach
        
    </tbody>
</table>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          <h2 class="text-center p-5">@lang('Are you sure to delete') ؟</h2>
        <form action="{{ url('admin/stores/destroy') }}" method="post">
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
{{ $stores->withQueryString()->links() }}
@endsection