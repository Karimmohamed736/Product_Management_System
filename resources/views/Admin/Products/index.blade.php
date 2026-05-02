@extends('Admin.Layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Stock</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->getFirstMediaUrl('main-image'))
                                <img src="{{ $product->getFirstMediaUrl('main-image') }}"
                                     width="50" height="50"
                                     class="rounded"
                                     style="object-fit: cover;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $product->getTranslation('title', 'en') }}</td>
                        <td>{{ $product->category?->getTranslation('name', 'en') ?? '—' }}</td>
                        <td>${{ $product->price }}</td>
                        <td>{{ $product->sale_price ? '$'.$product->sale_price : '—' }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->brand ?? '—' }}</td>
                        <td>
                            @if($product->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
