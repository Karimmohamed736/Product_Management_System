{{-- @include('admin.errors')
@include('admin.success') --}}

@extends('Admin.Layouts.app')
@section('content')
<form method="POST" action="{{route('admin.categories.update', $category->id)}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" style="color:red">{{$error}}</div>
            @endforeach
    @endif

    <div class="form-group">
      <label for="exampleInputEmail1">Category Name (EN)</label>
      <input type="text" name="name[en]" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name in English" value="{{ $category->getTranslation('name', 'en') }}">
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">Category Name (AR)</label>
      <input type="text" name="name[ar]" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name in Arabic" value="{{ $category->getTranslation('name', 'ar') }}">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Status</label>
        <select name="status" class="form-control text-white" id="exampleInputEmail1" >
            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1"> Parent_id</label>
        <select name="parent_id" class="form-control text-white" id="exampleInputEmail1">
            <option value="">Select Parent Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->getTranslation('name', 'en') }}</option>
            @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Category Image</label>
        <img src="{{ $category->getFirstMediaUrl('category-image') }}" alt="Category Image" width="100" height="100" class="mb-2 rounded" style="object-fit: cover;">
        <input type="file" name="image" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
      </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

