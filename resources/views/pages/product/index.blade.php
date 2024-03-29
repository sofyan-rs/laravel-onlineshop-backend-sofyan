@extends('layouts.app')

@section('title', 'Products')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Products</h1>
                <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Products</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('product.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search"
                                            value="{{ request()->query('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th class="text-center">Image</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            {{-- <th>Description</th> --}}
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Created At</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex justify-content-center p-2">
                                                        <?php if ($product->image): ?>
                                                        <img class="border rounded-circle"
                                                            src="{{ asset('storage/products/' . $product->image) }}"
                                                            alt="{{ $product->name }}" width="60px" />
                                                        <?php else: ?>
                                                        No Image
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>{{ $product->name }}
                                                </td>
                                                <td>
                                                    {{ $product->category->name }}
                                                </td>
                                                {{-- <td>
                                                    {{ $product->description }}
                                                </td> --}}
                                                <td>
                                                    {{ 'Rp ' . number_format($product->price, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    {{ $product->stock }}
                                                </td>
                                                <td>
                                                    {{ $product->created_at->format('d M Y, H:i') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('product.edit', $product->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('product.destroy', $product->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="float-right">
                                    {{ $products->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
