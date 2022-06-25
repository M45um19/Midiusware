<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $productQuery = Product::query();

        if (!empty($request->title)) {
            $productQuery->where('title', 'LIKE', "%{$request->title}%");
        }

        if (!empty($request->variant)) {

            $productQuery->whereHas('productVariants', function ($q) use ($request) {
                $q->where('variant', $request->variant);
            });
        }

        if (!empty($request->price_from)) {
            $productQuery->whereHas('productVariantPrice', function ($q) use ($request) {
                $q->where('price', '>=', $request->price_from);
            });
        }
        if (!empty($request->price_to)) {
            $productQuery->whereHas('productVariantPrice', function ($q) use ($request) {
                $q->where('price', '<=', $request->price_to);
            });
            //dd($productQuery->get()); 
        }

        if (!empty($request->date)) {
            $temp = Carbon::parse($request->date);
            $value = date_format($temp, 'Y-m-d');
            $productQuery->where('created_at', 'LIKE', "%{$value}%");
            //dd($productQuery->get());
        }

        $products = $productQuery->paginate(2);
        $variants = Variant::all();
        return view('products.index', [
            'products' => $products,
            'variants' => $variants
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
