@extends('layouts.dashboard.app')
@section('title')
@lang('Products')
@endsection
@section('content')

<div class="theme p-3">
<table class="table align-middle">
   
   <a href="{{ route('admin.products.create') }}" class="btn MyBtn mb-2"><span><i class="bi bi-plus"></i> @lang('Add')</span></a>
   
   <thead class="">
       <tr>
           <th>@lang('Name')</th>
           <th>@lang('Store')</th>
           <th>@lang('Category')</th>
           <th>@lang('Price')</th>
           <th>@lang('Compare Price')</th>
           <th>@lang('Quantity')</th>
           <th>@lang('status')</th>
           <th>@lang('image')</th>
           <th>@lang('Control')</th>
       </tr>
   </thead>
   <tbody>
       @foreach($products as $product)
       <tr>
           <td>{{ $product->name }}</td>
           <td>{{ $product->store->name }}</td>
           <td>{{ $product->category->name }}</td>
           <td>{{ $product->price }}</td>
           <td>{{ $product->compare_price }}</td>
           <td>{{ $product->quantity }}</td>
           <td  class="badge {{ $product->status == 'active' ? 'text-bg-success' : 'text-bg-danger'; }} ">{{ $product->status }}</td>
           <td>
               <img src="{{ $product->image_path }}" class="rounded-circle" alt="" style="width: 45px; height: 45px" />
           </td>
           <td class="d-flex gap-2">
               
               <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-outline-primary"><span><i class="bi bi-pencil-square"></i></span></a>
               
               <button class="btn btn-outline-danger"
               data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-userId="{{ $product->id }}"
               ><span><i class="bi bi-trash3"></i></span></button>
              
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
        <form action="{{ url('admin/products/destroy') }}" method="post">
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
{{ $products->withQueryString()->links() }}
@endsection