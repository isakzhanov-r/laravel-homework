<?php

namespace App\Http\Resources\Orders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

/** @see \App\Models\Order */
class GroupedCollection extends ResourceCollection
{
    protected $with_all;

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->groupCollection(),
        ];
    }

    private function groupCollection()
    {
        return collect([
            $this->newOrders('new', 'Новые', clone $this->collection),
            $this->currentOrders('current', 'Текущие', clone $this->collection),
            $this->completedOrders('completed', 'Выполненные', clone $this->collection),
            $this->pastDueOrders('past_due', 'Просроченные', $this->collection),
        ]);
    }

    private function newOrders($id, $title, $collection)
    {
        $items = $collection->filter(function (Order $item) {
            return $item->delivery_at > now() && $item->status === 0;
        })
            ->values()
            ->transform(function (Order $item) {
                return new OrderResource($item);
            });

        return compact('id', 'title', 'items');
    }

    private function currentOrders($id, $title, $collection)
    {
        $items = $collection->filter(function (Order $item) {
            return $item->delivery_at >= now()->addHours(24) && $item->status === 10;
        })
            ->values()
            ->transform(function (Order $item) {
                return new OrderResource($item);
            });

        return compact('id', 'title', 'items');
    }

    private function completedOrders($id, $title, $collection)
    {
        $items = $collection
            ->whereBetween('delivery_at', [Carbon::today(), Carbon::today()->addHours(24)])
            ->where('status', '=', 20)
            ->values()
            ->transform(function (Order $item) {
                return new OrderResource($item);
            });

        return compact('id', 'title', 'items');
    }

    private function pastDueOrders($id, $title, $collection)
    {
        $items = $collection->filter(function (Order $item) {
            return $item->delivery_at < now() && $item->status === 10;
        })
            ->values()
            ->transform(function (Order $item) {
                return new OrderResource($item);
            });

        return compact('id', 'title', 'items');
    }
}
