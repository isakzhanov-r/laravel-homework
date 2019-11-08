<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryContract;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderRepositoryContract $order_repository_contract)
    {
        $this->order = $order_repository_contract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->order->getAll();

        return response()->json($data);
    }

    /**
     * Display a groped listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grouped()
    {
        $data = $this->order->getGrouped(true);

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->order->getOrder($id);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($this->order->destroy($order)) {
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'fail'], 400);
    }
}
