@extends('Admin.Layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Update Product</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title (English)</label>
                        <input type="text" name="title[en]" class="form-control" value="{{ old('title.en', $product->getTranslation('title', 'en')) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title (Arabic)</label>
                        <input type="text" name="title[ar]" class="form-control" value="{{ old('title.ar', $product->getTranslation('title', 'ar')) }}" dir="rtl">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description[en]" class="form-control" rows="3">{{ old('description.en', $product->getTranslation('description', 'en')) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description (Arabic)</label>
                        <textarea name="description[ar]" class="form-control" rows="3" dir="rtl">{{ old('description.ar', $product->getTranslation('description', 'ar')) }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sale Price</label>
                        <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->getTranslation('name', 'en') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Main Image</label>
                    @if($product->getFirstMediaUrl('main-image'))
                        <div class="mb-2">
                            <img src="{{ $product->getFirstMediaUrl('main-image') }}"
                                 width="100" height="100"
                                 class="rounded"
                                 style="object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" name="main-image" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gallery Images</label>
                    @if($product->getMedia('gallery')->count())
                        <div class="mb-2 d-flex flex-wrap gap-2">
                            @foreach($product->getMedia('gallery') as $media)
                                <div class="position-relative">
                                    <img src="{{ $media->getUrl() }}"
                                         width="100" height="100"
                                         class="rounded"
                                         style="object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                </div>

                <div class="mb-3">
                    <label class="form-label">Files (PDF)</label>
                    @if($product->getMedia('files')->count())
                        <ul class="list-group mb-2">
                            @foreach($product->getMedia('files') as $media)
                                <li class="list-group-item">
                                    <a href="{{ $media->getUrl() }}" target="_blank">{{ $media->file_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <input type="file" name="files[]" class="form-control" accept=".pdf" multiple>
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
