<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Resources\Orders\GroupedCollection;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderRepository $order_repository_contract)
    {
        $this->order = $order_repository_contract;
    }

    public function index()
    {
        $data = $this->order
            ->getAll();

        return OrderResource::collection($data);
    }

    public function grouped()
    {
        $data = $this->order
            ->getAll();

        return GroupedCollection::make($data);

        //return response()->json($data);
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
    public function update(UpdateRequest $request, Order $order)
    {
        $this->order->update($request, $order);

        return response()->json(['message' => 'Обновлено']);
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
