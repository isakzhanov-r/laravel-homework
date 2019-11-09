<?php


namespace App\Repositories\Partner;


use App\Models\Partner;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PartnerRepository extends BaseRepository implements PartnerRepositoryContract
{
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }

    public function getAll(): EloquentCollection
    {
        return $this->model->query()
            ->get();
    }
}
