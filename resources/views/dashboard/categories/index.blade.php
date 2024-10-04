@extends('layouts.dashboard')

@section('title','Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="mb-5">
<a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
<a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a>
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
            <th>Parent</th>
            <th>Product #</th>
            <th>Status</th>
            <th>Created</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
        <tr>
            <td><img src="{{asset('storage/' .$category->image)}}" alt="" height="50"></td>
            <td>{{$category->id}}</td>
            <td><a href="{{route('dashboard.categories.show',$category->id)}}">{{$category->name}}</a></td>
            <td>{{$category->parent->name}}</td>
            <td>{{$category->products_number}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->created_at}}</td>
            <td>
                @can('categories.update')
                <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                @endcan
            </td>
            <td>
                <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="9">No categories defined</td>
            </tr>
        
        @endforelse
    </tbody>
</table>
{{$categories->withQueryString()->links()}}
@endsection