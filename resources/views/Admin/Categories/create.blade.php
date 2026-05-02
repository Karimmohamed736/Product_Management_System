{{-- @include('admin.errors')
@include('admin.success') --}}

@extends('Admin.Layouts.app')
@section('content')
<form method="POST" action="{{route('admin.categories.store')}}" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" style="color:red">{{$error}}</div>
            @endforeach
    @endif

    <div class="form-group">
      <label for="exampleInputEmail1">Category Name (EN)</label>
      <input type="text" name="name[en]" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name in English">
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">Category Name (AR)</label>
      <input type="text" name="name[ar]" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name in Arabic">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Status</label>
        <select name="status" class="form-control text-white" id="exampleInputEmail1">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1"> Parent_id</label>
        <select name="parent_id" class="form-control text-white" id="exampleInputEmail1">
            <option value="">Select Parent Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->getTranslation('name', 'en') }}</option>
            @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Category Image</label>
        <input type="file" name="image" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
      </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

