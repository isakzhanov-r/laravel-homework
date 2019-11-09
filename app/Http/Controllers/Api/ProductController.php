<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryContract;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $products;

    public function __construct(ProductRepositoryContract $product_repository_contract)
    {
        $this->products = $product_repository_contract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->products->getAll();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
