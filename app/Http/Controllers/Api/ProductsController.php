<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Product\Store;
use App\Http\Requests\Product\Update;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $with_stocks = $request->input('with_stocks');

        $products = Product::when($request->has('search'), function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        })
        ->when($with_stocks == "true", function ($query) use ($with_stocks) {
            $query->where('quantity', '>', 0 );
        })
        ->when($with_stocks == "false", function ($query) use ($with_stocks) {
            $query->where('quantity', '<', 1 );
        })
        ->get();

        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        try {
            $data = collect($request->validated())->toArray();
            $product = Product::create($data);
            return new ProductResource($product);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return new ProductResource($product);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        try {
            $data = collect($request->validated())
            ->except(['id'])
            ->toArray();
            $product = Product::findOrFail($id);
            $product->update($data);
            return new ProductResource($product);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json('success', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
