@extends('layouts.dashboard')

@section('title','Trash Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')
<div class="mb-5">
<a href="{{route('dashboard.categories.index')}}" class="btn btn-sm btn-outline-primary">Back</a>
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
            <th>Status</th>
            <th>Deleted</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
        <tr>
            <td><img src="{{asset('storage/' .$category->image)}}" alt="" height="50"></td>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->deleted_at}}</td>
            <td>
                <form action="{{route('dashboard.categories.restore',$category->id)}}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                </form>
            </td>
            <td>
                <form action="{{route('dashboard.categories.force-delete',$category->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="7">No categories defined</td>
            </tr>
        
        @endforelse
    </tbody>
</table>
{{$categories->withQueryString()->links()}}
@endsection