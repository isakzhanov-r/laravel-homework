<?php


namespace App\Repositories\Order;


use App\Models\Order;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


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

    public function grouped($with_all = false): Collection
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

    protected function groupedNew(): Collection
    {
        return $this->model->query()->where('delivery_at', '>', Carbon::now())
            ->where('status', '=', 0)->limit(50)->get();
    }

    protected function groupedPastDue(): Collection
    {
        return $this->model->query()->where('delivery_at', '<', Carbon::now())
            ->where('status', '=', 10)->limit(50)->get();
    }

    protected function groupedCurrent(): Collection
    {
        return $this->model->query()->where('delivery_at', '>=', Carbon::now()->addHours(24))
            ->where('status', '=', 10)->get();
    }

    protected function groupedCompleted(): Collection
    {
        return $this->model->query()->whereBetween('delivery_at', [Carbon::today(), Carbon::today()->addHours(24)])
            ->where('status', '=', 20)->limit(50)->get();
    }
}
