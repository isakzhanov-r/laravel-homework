<?php


namespace App\Repositories\Partner;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface PartnerRepositoryContract
{
    public function getAll():EloquentCollection;
}
