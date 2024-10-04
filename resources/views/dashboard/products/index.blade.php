@extends('layouts.dashboard')

@section('title','Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
<div class="mb-5">
<a href="{{route('dashboard.products.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
{{-- <a href="{{route('dashboard.products.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a> --}}
</div>
<x-alert type="success" />
<x-alert type="info" />
<form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
    <input type="text" name="name"  class="form-control" placeholder="Name" value="{{request('name')}}" >
    <select name="status" class="form-control">
        <option value="">All</option>
        <option value="active">Active</option>
        <option value="archived">Archived</option>
    </select>
    <button class="btn btn-dark">Filter</button>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Images</th>
            <th>ID</th>
            <th>Named</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr>
            <td><img src="{{asset('storage/' .$product->image)}}" alt="" height="50"></td>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->category->name}}</td>
            <td>{{$product->store->name}}</td>
            <td>{{$product->status}}</td>
            <td>{{$product->created_at}}</td>
            <td>
                <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="7">No products defined</td>
            </tr>
        
        @endforelse
    </tbody>
</table>
{{$products->withQueryString()->links()}}
@endsection