@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control"
                        @isset($_GET['title']) value= {{ $_GET['title'] }} @endisset>
                </div>
                <div class="col-md-2">
                    <select name="variant" class="form-control">
                        <option disabled selected>select variant</option>
                        @foreach ($variants as $variant)
                            <option disabled>{{ $variant->title }}</option>
                            <?php
                            $uniqueVariants = $variant->productVariants->unique('variant');
                            ?>
                            @foreach ($uniqueVariants as $item)
                                <option value={{ $item->variant }}
                                    @isset($_GET['variant']) @if ($_GET['variant'] == $item->variant) @selected(true) @endif
                                @endisset>&nbsp; &nbsp;{{ $item->variant }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Price Range</span>
                    </div>
                    <input type="text" name="price_from" aria-label="First name" placeholder="From"
                        class="form-control"
                        @isset($_GET['price_from']) value= {{ $_GET['price_from'] }} @endisset>
                    <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control"
                        @isset($_GET['price_to']) value= {{ $_GET['price_to'] }} @endisset>
                </div>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" placeholder="Date" class="form-control"
                    @isset($_GET['date']) value= {{ $_GET['date'] }} @endisset>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="card-body">
        <div class="table-response">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->title }} <br> Created at : {{ $item->created_at->diffForHumans() }}</td>
                            <td>
                                {{ $item->description }}
                            </td>
                            <td>
                                <dl class="row mb-0" style="height: 80px; overflow: hidden"
                                    id="variant{{ $item->id }}">

                                    <dt class="col-sm-4 pb-0">
                                        @foreach ($item->productVariants as $itemVariant)
                                            {{ $itemVariant->variant }} /
                                        @endforeach
                                    </dt>
                                    <dd class="col-sm-8">
                                        <dl class="row mb-0">
                                            @foreach ($item->productVariantPrice as $itemVariantPrice)
                                                <dt class="col-sm-6 pb-0">Price : {{ $itemVariantPrice->price }}
                                                </dt>
                                                <dd class="col-sm-6 pb-0">InStock : {{ $itemVariantPrice->stock }}
                                                </dd>
                                            @endforeach
                                        </dl>
                                    </dd>
                                </dl>
                                <button onclick="$('#variant{{ $item->id }}').toggleClass('h-auto')"
                                    class="btn btn-sm btn-link">Show more</button>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>

    <div class="card-footer">
        <div class="">
            {!! $products->appends($_GET)->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>
@endsection
