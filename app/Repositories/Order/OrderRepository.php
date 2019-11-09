<?php


namespace App\Repositories\Order;


use App\Http\Requests\Order\UpdateRequest;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Mail;
use function Sodium\compare;


class OrderRepository extends BaseRepository implements OrderRepositoryContract
{
    /**
     * OrderRepository constructor.
     *
     * @param \App\Models\Order $model
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getAll(): EloquentCollection
    {
        return $this->model->query()
            ->with('partner', 'products')
            ->get();
    }

    public function getGrouped($with_all = false): Collection
    {
        $data = collect();
        if ($with_all) {
            $data->push(['id' => 'all', 'title' => 'Все', 'items' => $this->getAll()]);
        }
        $data->push(['id' => 'new', 'title' => 'Новые', 'items' => $this->groupedNew()]);
        $data->push(['id' => 'current', 'title' => 'Текущие', 'items' => $this->groupedCurrent()]);
        $data->push(['id' => 'completed', 'title' => 'Выполненные', 'items' => $this->groupedCompleted()]);
        $data->push(['id' => 'past_due', 'title' => 'Просроченные', 'items' => $this->groupedPastDue()]);

        return $data;
    }

    public function getOrder($id): Order
    {
        return $this->model->query()
            ->with('partner', 'products')
            ->findOrFail($id);
    }

    public function update(UpdateRequest $request, Order $order): Order
    {
        $fillable = $this->model->getFillable();
        $order->update($request->only($fillable));
        $this->syncProducts($request, $order);
        $this->sendMail($order);

        return $order;
    }

    public function destroy(Order $order)
    {
        return $order->delete();
    }

    protected function groupedNew(int $limit = 50): Collection
    {
        return $this->model->query()
            ->where('delivery_at', '>', Carbon::now())
            ->where('status', '=', 0)
            ->with('partner', 'products')
            ->limit($limit)
            ->get();
    }

    protected function groupedPastDue(int $limit = 50): Collection
    {
        return $this->model->query()
            ->where('delivery_at', '<', Carbon::now())
            ->where('status', '=', 10)
            ->with('partner', 'products')
            ->limit($limit)
            ->get();
    }

    protected function groupedCurrent(): Collection
    {
        return $this->model->query()
            ->where('delivery_at', '>=', Carbon::now()->addHours(24))
            ->where('status', '=', 10)
            ->with('partner', 'products')->get();
    }

    protected function groupedCompleted(int $limit = 50): Collection
    {
        return $this->model->query()
            ->whereBetween('delivery_at', [Carbon::today(), Carbon::today()->addHours(24)])
            ->where('status', '=', 20)
            ->with('partner', 'products')
            ->limit($limit)
            ->get();
    }

    protected function syncProducts(UpdateRequest $request, Order $order)
    {
        $pivot    = [];
        $products = $request->products;
        foreach ($products as $product) {
            $quantity              = $product['pivot']['quantity'];
            $price                 = $product['pivot']['price'];
            $pivot[$product['id']] = compact('price', 'quantity');
        }
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
