<?php


namespace App\Repositories\Eloquent;


use App\Http\Requests\Order\UpdateRequest;
use App\Mail\OrderMail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class OrderRepository
{
    public function getAll(): Collection
    {
        return Order::query()->get()
            ->load('partner', 'products');
    }

    public function getOrder(Order $order): Order
    {
        return $order
            ->load('partner', 'products');
    }

    public function update(UpdateRequest $request, Order $order): Order
    {
        $order->update($request->validated());
        $this->syncProducts($request, $order);
        $this->sendMail($order);

        return $order;
    }

    public function destroy(Order $order)
    {
        return $order->delete();
    }

    protected function syncProducts(UpdateRequest $request, Order $order)
    {
        $pivot    = [];
        $products = $request->products;

        array_map(function ($product) use (&$pivot, $order) {
            $id       = Arr::get($product, 'id');
            $price    = Arr::get($product, 'price');
            $quantity = Arr::get($product, 'pivot.quantity');
            Arr::set($pivot, compact('id', 'price', 'quantity'));
        }, $products);

        $order->products()->sync($pivot);
    }

    protected function sendMail(Order $order)
    {
        if ($order->status === 20) {
            $mail = new OrderMail($order);

            Mail::send($mail);
        }
    }
}
